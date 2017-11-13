<?php
class Transformer{

    protected $records;

    public function __construct($alma_json) {
        $this->records = $alma_json;
    }

    public function array_to_json(){
        $final['ok']='true';
        foreach($this->records as $record):
            $record = json_decode($record,true);
            //simplify the array
            $fields = $this->parse_fields($record['fields']);
            $result = $this->transform($fields);
            $final['results'][]= $result;
        endforeach;

        return json_encode($final);
    }

    public function get_array(){
        $final['ok']='true';
        foreach($this->records as $record):
            $record = json_decode($record,true);
            //simplify the array
            $fields = $this->parse_fields($record['fields']);
            if(isset($record['representation'])):
              foreach($record['representation'] as $rep):
                $fields[]['representation'] = $rep;
              endforeach;
              $representation = true;
            else:
              $representation = false;
            endif;

            $result = $this->transform($fields,$representation);
            $final['results'][]= $result;
        endforeach;

        return $final;
    }

    public function parse_fields($fields){
        $result='';
        foreach($fields as $field):
            if(is_array($field[key($field)]['subfields'])):
                $subfields = $field[key($field)]['subfields'];
                $temp='';
                foreach($subfields as $code):
                    $temp[key($code)]=$code[key($code)];
                endforeach;
                $field[key($field)]['subfields']=$temp;
            endif;
            $result[][key($field)]=$field[key($field)];

        endforeach;
        return $result;
    }

    public function get_record(){
        return $this->array_to_json();
    }

    public function transform($fields,$representation){
        $result="";

        /*
          spatial: 264a
          publisher: 264b

          collectie? 852c
          plaatskenmerk 852hik
        */

        foreach($fields as $field):
            //mms id & LIMO link
            if(isset($field["001"])):
                $result["object_id"][]=$field["001"];
                $result["LIMO"][]="https://services.libis.be/query?institution=KUL&view=KULeuven&query=any:".$field["001"];
            endif;

            //date (facet) & language (iso)
            if(isset($field["008"])):
                $result["date"][]= substr($field["008"],8,4);
                $result["language"][]= substr($field["008"],36,3);
            endif;

            //title
            if(isset($field["245"])):
                $title = $field["245"]['subfields']['a'];

                if(isset($field["245"]['subfields']['b'])):
                  $title .= $field["245"]['subfields']['b'];
                endif;
                if(isset($field["245"]['subfields']['c'])):
                  $title .= $field["245"]['subfields']['c'];
                endif;
                $result["title"][] = $title;
            endif;

            //alternative title
            if(isset($field["246"])):
                $alttitle = $field["246"]['subfields']['a'];

                if(isset($field["246"]['subfields']['b'])):
                  $alttitle .= $field["246"]['subfields']['b'];
                endif;
                $result["alternative_title"][]= $alttitle;
            endif;

            //place
            if(isset($field["710"])):
                $result["place"][]=$field["710"]['subfields']['c'];
            endif;

            //publisher
            if(isset($field["710"])):
                $result["publisher"][]=$field["710"]['subfields']['a'];
            endif;

            //images
            if(isset($field["representation"])):
              $result["pid"][]= $field["representation"]["linking_parameter_1"];
            elseif(isset($field["856"]) && !$representation):
                if($field["856"]["ind1"]=='4'&&$field["856"]["ind2"]=='0'):
                    if (strpos($field["856"]['subfields']['u'], 'pid=') !== false) {
                        $pid = explode('pid=', $field["856"]['subfields']['u']);
                        $pid = end($pid);
                        $result["pid"][] = $pid;
                    }
                    if (strpos($field["856"]['subfields']['u'], 'resolver.libis') !== false) {
                        $pid = explode('/', $field["856"]['subfields']['u']);
                        $pid = $pid[3];
                        $result["pid"][] = $pid;
                    }
                endif;
            endif;

            //date (period for display)
            if(isset($field["264"])):
                if($field["264"]["ind1"]==' '&&$field["264"]["ind2"]=='1'):
                    $data=$field["264"]['subfields']['c'];
                    $result["period"][] = str_replace('.', '', $data);
                endif;
            endif;

            //description
            if (isset($field["300"])):
                if($field["300"]["ind1"]==' '&&$field["300"]["ind2"]==' '):
    			        $data = $field["300"]['subfields']['a'];

    			        if (isset($field["300"]['subfields']['b'])) {
    				        $data .= " : ".$field["300"]['subfields']['b'];
    			        }
    			        if (isset($field["300"]['subfields']['c'])) {
    				        // if b is null, there is no need for a ; because subfields a ends with a ;
    				        if (isset($field["300"]['subfields']['b'])) {
    					        $data .= " ; ";
    				        }
    				        $data .= $field["300"]['subfields']['c'];
    			        }
    			        $result["description"][]=$data;
                endif;
            endif;

            //source and identifiers
            if(isset($field["852"])){
                if (isset($field["852"]['subfields']['c'])) {
			             $result['source'][] =$field["852"]['subfields']['c'];
                }
    				    if (isset($field["852"]['subfields']['i'])) {
    					    $result["identifier"][] = $field["852"]['subfields']['i'];
    				    }
                if (isset($field["852"]['subfields']['k'])) {
    					    $result["identifier"][] = $field["852"]['subfields']['k'];
    				    }
                if (isset($field["852"]['subfields']['h'])) {
    					    $result["identifier"][] = $field["852"]['subfields']['h'];
    				    }
                if (isset($field["852"]['subfields']['l'])) {
    					    $result["identifier"][] = $field["852"]['subfields']['l'];
    				    }
                if (isset($field["852"]['subfields']['m'])) {
    					    $result["identifier"][] = $field["852"]['subfields']['m'];
    				    }
            }

            //creator & contributor
            if (isset($field["700"])):
  			       $data="";

      			    if (isset($field["700"]['subfields']['a'])) {
      				    $data .= $field["700"]['subfields']['a'];
      			    }
      			    if (isset($field["700"]['subfields']['b'])) {
                  $data .= " ".$field["700"]['subfields']['b'];
      			    }
      			    if (isset($field["700"]['subfields']['d'])) {
      				    $data .=" ". $field["700"]['subfields']['d'];
      			    }

  	            if ($field["700"]['subfields']['4']=="aut") {

  		            $result["Creator"][]=$data;

  	            } else {
  		            $result["Contributor"][]=$data;
  	            }
            endif;
        endforeach;

        foreach($result as $key=>$value):
            $result_imploded[$key]=implode("$$",$value);
        endforeach;

        return $result_imploded;
    }
}
?>
