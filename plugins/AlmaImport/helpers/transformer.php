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

            if(isset($record['portfolio'])):
              foreach($record['portfolio'] as $port):
                $fields[]['portfolio'] = $port;
              endforeach;
            endif;

            $result = $this->transform($fields,$representation);
            $final['results'][]= $result;
        endforeach;

        return $final;
    }

    public function parse_fields($fields){
        $result=array();
        foreach($fields as $field):
            if(isset($field[key($field)]['subfields'])):
                $subfields = $field[key($field)]['subfields'];
                if(is_array($subfields)):
                  $temp=array();
                  foreach($subfields as $code):
                      $temp[key($code)]=$code[key($code)];
                  endforeach;
                  $field[key($field)]['subfields']=$temp;
                endif;
            endif;
            $result[][key($field)]=$field[key($field)];

        endforeach;
        return $result;
    }

    public function get_record(){
        return $this->array_to_json();
    }

    public function transform($fields,$representation){
        $result=array();
        /*echo '<pre>';
        var_dump($fields);
        echo '</pre>';*/
        $result['source'][0] = "Other libraries";  

        foreach($fields as $field):
            //mms id & LIMO link
            if(isset($field["001"])):
                $result["object_id"][]= str_replace("A","",$field["001"]);
                $result["LIMO"][]="https://services.libis.be/query?institution=KUL&view=KULeuven&query=any:".$field["001"];
            endif;

            //date (facet) & language (iso)
            if(isset($field["008"])):
                $result["date"][]= substr($field["008"],7,4);
                $language = substr($field["008"],35,3);
                if($language == "fre"):
                  $language = "fr";
                endif;
                $result["language"][] = $language;
            endif;

            //title
            if(isset($field["245"])):
                $title = $field["245"]['subfields']['a'];

                if(isset($field["245"]['subfields']['b'])):
                  $title .= " ".$field["245"]['subfields']['b'];
                endif;
                if(isset($field["245"]['subfields']['c'])):
                  $title .= " ".$field["245"]['subfields']['c'];
                endif;
                $result["title"][] = $title;
            endif;

            //alternative title
            if(isset($field["246"])):
                $alttitle = $field["246"]['subfields']['a'];

                if(isset($field["246"]['subfields']['b'])):
                  $alttitle .= " ".$field["246"]['subfields']['b'];
                endif;
                $result["alternative_title"][]= $alttitle;
            endif;

            //place, publisher, author and contributor 710
            if(isset($field["710"])):
              if($field["710"]['subfields']['e']=="printer" || $field["710"]['subfields']['e']=="publisher"
              || $field["710"]['subfields']['e']=="bookseller"):
                $place = $field["710"]['subfields']['c'];
                if($place == "Brussel" || $place == "Bruxelles"):
                  $place = "Brussel / Bruxelles";
                endif;
                $result["place"][] = $place;
                $result["place"] = array_unique($result["place"]);

                $result["publisher"][]=$field["710"]['subfields']['a'];
              elseif($field["710"]['subfields']['e']=="author"):
                $result["creator"][]=$field["710"]['subfields']['a'];
              else:
                $result["contributor"][]=$field["710"]['subfields']['a'];
              endif;
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
                //external source
                if($field["856"]["ind1"]=='4'&&$field["856"]["ind2"]=='1'):
                    if (isset($field["856"]['subfields']['u'])) {
                        $url = $field["856"]['subfields']['u'];
                        $label = "";
                        if (isset($field["856"]['subfields']['y'])) {
                            $label = $field["856"]['subfields']['y'];
                            preg_match('#\((.*?)\)#', $label, $match);
                            if($match):
                              $label = "(".$match[1].")";
                            else:
                              $label = "";
                            endif;
                        }
                        if (isset($field["856"]['subfields']['z'])) {
                            $name = $field["856"]['subfields']['z'];
                        }

                        $result['external manuscript'][]= "<a target='_blank' href='".$url."'>".$name." ".$label."</a>";
                        $result['external manuscript txt'][]= $name;
                    }
                endif;
            endif;

            if(isset($field["portfolio"]) && !isset($field["856"])){
              if($field["portfolio"]["linking_details"]){
                $url = str_replace("jkey=","",$field["portfolio"]["linking_details"]["static_url"]);                

                if($field["portfolio"]["public_note"]):
                  $label = $field["portfolio"]["public_note"];
                  $label = explode(": ",$label);
                  $result['external manuscript'][]= '<a href="'.$url.'">'.$label[1].'</a>';
                else:
                  $result['external manuscript'][]= '<a href="'.$url.'">'.$url.'</a>';
                endif;                
              }
              if($field["portfolio"]["public_note"]):
                $result['external manuscript txt'][]= $field["portfolio"]["public_note"];
              endif;
            }

            if(isset($field["852"])){
                if (isset($field["852"]['subfields']['b'])) {
                  if ($field["852"]['subfields']['b'] == 'BCOL' || $field["852"]['subfields']['b'] == 'GBIB') {
                    if($field["852"]['subfields']['b'] == "BCOL"):
                      $value = "KU Leuven Libraries, Special Collections,";
                      $result["physical copy filter"][] = "KU Leuven Libraries, Special Collections";
                    elseif($field["852"]['subfields']['b'] == "GBIB"):
                      $value = "KU Leuven Libraries, Maurits Sabbe Library,";
                      $result["physical copy filter"][] = "KU Leuven Libraries, Maurits Sabbe Library";
                    endif;

                    if (isset($field["852"]['subfields']['k'])) {
    			             $value .= ' '.$field["852"]['subfields']['k'];
                    }
                    if(isset($field["852"]['subfields']['h'])) {
    			             $value .= ' '.$field["852"]['subfields']['h'];
                    }
                    if(isset($field["852"]['subfields']['i'])) {
    			             $value .= ' '.$field["852"]['subfields']['i'];
                    }
                    if(isset($field["852"]['subfields']['l'])) {
    			             $value .= ' '.$field["852"]['subfields']['l'];
                    }
                    if(isset($field["852"]['subfields']['m'])) {
    			             $value .= ' '.$field["852"]['subfields']['m'];
                    }

                    $result["hasVersion"][] = $value;
                  }
                }
            }

            //date (period for display)
            if(isset($field["264"])):
                if(isset($field["264"]['subfields']['c'])):
                    $data=$field["264"]['subfields']['c'];
                    $result["period"][] = str_replace('.', '', $data);
                endif;
            endif;

            //description
            if (isset($field["300"])):
                if(isset($field["300"]['subfields']["a"])):
    			        $data = $field["300"]['subfields']['a'];

    			        if (isset($field["300"]['subfields']['g'])) {
    				        $data .= " (".$field["300"]['subfields']['g'].")";
    			        }

    			        $result["description"][]=$data;
                endif;
            endif;

            //source and identifiers
            if(isset($field["representation"])){
              $label = $field["representation"]["label"];
              $label = ltrim($label);
              $label = explode(" ", $label);
              //KU Leuven Libraries
              $source = $label[0]." ".$label[1]." ".$label[2].",";
              //Librabry
              if($label[3] == "BIBC"):
                $source .= " Special Collections";
              elseif($label[3] == "BCOL"):
                $source .= " Special Collections";
              elseif($label[3] == "GBIB"):
                $source .= " Maurits Sabbe Library";
              endif;

              //Sigel not needed
              $result['source'][0] = $source;

              $temp = array_slice($label,5);

              $result["identifier"][] = mb_convert_encoding(implode(' ',$temp), 'UTF-8', 'HTML-ENTITIES');
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
      				    $data .=" (". $field["700"]['subfields']['d'].")";
      			    }

  	            if ($field["700"]['subfields']['e']=="author") {

  		            $result["creator"][]=$data;

  	            } else {
  		            $result["contributor"][]=$data;
  	            }
            endif;

            if (isset($field["100"])):
              $data="";
              if (isset($field["100"]['subfields']['a'])) {
                $data .= $field["100"]['subfields']['a'];
              }
              if (isset($field["100"]['subfields']['b'])) {
                $data .= " ".$field["100"]['subfields']['b'];
              }
              if (isset($field["100"]['subfields']['d'])) {
                $data .=" (". $field["100"]['subfields']['d'].")";
              }
              //    if(isset($field["700"]['subfields']['e'])):
              //$result["creator"][]= $field["700"]['subfields']['e'];
              //endif;
              if($data):
                $result["creator"][]=$data;
              endif;
            endif;
        endforeach;

        foreach($result as $key=>$value):
            $result_imploded[$key]=implode("$$",$value);
        endforeach;

        return $result_imploded;
    }
}
?>
