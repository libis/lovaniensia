<?php

$path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'marc';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);
require 'File/MARC.php';
require 'File/MARCXML.php';

class AlmaTalker{

    protected $object_id;
    protected $key;
    protected $alma_url = "https://api-eu.hosted.exlibrisgroup.com/almaws/v1/bibs/";

    public function __construct($id,$key) {
        $this->object_id = $id;
        $this->key = $key;
    }

    public function get_id(){
        return $id;
    }

    public function alma_curl($url){
        $ch = curl_init($url);

        $options = array(
            CURLOPT_HEADER => "Content-Type:application/xml",
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_PROXY => get_option('alma_import_proxy')
        );
        curl_setopt_array($ch, $options);

        $alma_xml = curl_exec($ch);

        if (curl_errno($ch)) {
            // this would be your first hint that something went wrong
            die('Couldn\'t send request: ' . curl_error($ch));
        } else {
            // check the HTTP status code of the request
            $resultStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($resultStatus == 200) {
                // everything went better than expected
            } else {
                // the request did not complete as expected. common errors are 4xx
                // (not found, bad request, etc.) and 5xx (usually concerning
                // errors/exceptions in the remote script execution)

                die('Request failed: HTTP status code: ' . $resultStatus);
            }
        }

        curl_close($ch);
        return $alma_xml;
    }

    public function get_bibrecord(){
        $bibrecord = $this->alma_curl($this->alma_url.$this->object_id."?apikey=".$this->key);
        //$record = json_encode($bibrecord);
        $record = new File_MARCXML($bibrecord,File_MARC::SOURCE_STRING);
        return $record;
    }

    public function get_representation_links(){
        $rep_links = array();
        $reps = $this->alma_curl($this->alma_url.$this->object_id."/representations?apikey=".$this->key);
        $reps = new SimpleXMLElement($reps);
        foreach($reps as $rep):
            if($rep->id):
                $attr = $rep->attributes();
                $rep_links[]=$attr['link'];
            endif;
        endforeach;
        return $rep_links;
    }

    public function get_representations(){
        $links = $this->get_representation_links();
        $records=array();
        //exit(var_dump($links));
        foreach($links as $link):
            $rep = $this->alma_curl($link."?apikey=".$this->key);
            $rep = new SimpleXMLElement($rep);
            //$record = new File_MARCXML($rep,File_MARC::SOURCE_STRING);
            $records[] = $rep;
        endforeach;
        return $records;
    }

    public function get_holdings_links(){
        $hold_links = array();
        $holdings = $this->alma_curl($this->alma_url.$this->object_id."/holdings?apikey=".$this->key);
        $holdings = new SimpleXMLElement($holdings);
        foreach($holdings as $hold):
            if($hold->holding_id):
                $attr = $hold->attributes();
                $hold_links[]=$attr['link'];
            endif;
        endforeach;
        return $hold_links;
    }

    public function get_holdings(){
        $links = $this->get_holdings_links();
        $records = array();

        foreach($links as $link):
            $holding = $this->alma_curl($link."?apikey=".$this->key);
            $record = new File_MARCXML($holding,File_MARC::SOURCE_STRING);
            $records[] = $record;
        endforeach;
        return $records;
    }

    public function make_marc_json(){
        $bibrecord = $this->get_bibrecord();
        $holdings = $this->get_holdings();
        $reps = $this->get_representations();
        //var_dump($bibrecord);
        $json="";

        while ($record = $bibrecord->next()) {
            //this is the bibrecord
            $rep_json = array();

            foreach($holdings as $holding):
                while ($record_hold = $holding->next()) {
                    //these are the holding records
                    $fields = $record_hold->getFields();
                    foreach($fields as $field):
                        if($field->isDataField()):
                            $record->appendField($field);
                        endif;
                    endforeach;
                }
            endforeach;

            foreach($reps as $rep):
                $rep_json[] = $rep;
                /*while ($record_rep = $rep->next()) {
                    //these are the representation records
                    $fields = $record_rep->getFields();
                    foreach($fields as $field):
                        if($field->isDataField()):
                            $record->appendField($field);
                        endif;
                    endforeach;
                }*/
            endforeach;

            $json_record = $record->toJSON();
            $json_array = json_decode($json_record,true);
            if(!empty($rep_json)):
              $json_array['representation'] = $rep_json;
            endif;
            $json_record = json_encode($json_array);
            $json .= $json_record;
        }
        //exit(var_dump($json));
        return $json;
    }

}
?>
