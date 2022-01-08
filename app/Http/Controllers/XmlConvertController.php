<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Job;

class XmlConvertController extends Controller
{

    public function convertXmlToJson($xmlUrl)
    {

        // Read entire file into string 
        $xmlfile = file_get_contents($xmlUrl); 

        // Convert xml string into an object 
        $new = simplexml_load_string($xmlfile); 

        // Convert into json 
        $con = json_encode($new); 

        return json_decode($con, true); 

    }

    /**
     * $jons est
    */
    public function filterData($data, $element)
    {
        // return $json[$element];
        return array_filter($data[$element]);
    }

   

    public function convertToXml()
    {
        $path = "https://histoiredor.easycruit.com/export/xml/vacancy/list.xml";

        $data = $this->convertXmlToJson($path);
        
        $filterData = $this->filterData($data, "Vacancy");

        //  dd($jsonFilter);

        // $data = $newArr["Vacancy"];
        // dd($data);

        $jobs = [];
        $dataLangues = '';

        foreach($filterData as $offres) {
            $attributes = array_filter(($offres["@attributes"]));
            //   dd($attributes);

            $LesVersions = array_filter(($offres["Versions"]["Version"]));
            $departments = array_filter(($offres["Departments"]));
            //    dd($departments);
            

                //   array_push($jobs, new Job($attributes['id'], $attributes['date_start'], $attributes['date_end'],
                //   $attributes['reference_number'], $LesVersions['Title']
               //    $versions['Region'],  $versions['Categories']
// ));
            // foreach($LesVersions as $versionN ) {
            //     dd($versionN['Title']);
            //     $versions =  array_filter($versionN);
            //       dd($versions['Title']);
                $dataLangues = $LesVersions['@attributes'];

                if($dataLangues['language'] == "fr") {
                        //  dd($LesVersions);
                    
                    if(array_key_exists("Title", $LesVersions) && array_key_exists("TitleHeading", $LesVersions)
                    && array_key_exists("AlternativeCompanyName", $LesVersions) && array_key_exists("Location", $LesVersions) 
                    && array_key_exists('Region', $LesVersions) && array_key_exists('Country', $LesVersions['Region'])
                    && array_key_exists('County', $LesVersions['Region']['Country']) && array_key_exists('Categories', $LesVersions)
                    && array_key_exists('Item', $LesVersions['Categories']) && array_key_exists('Departments', $offres)
                    && array_key_exists('Department', $departments) && array_key_exists('@attributes', $departments["Department"])
                    && array_key_exists('id', $departments["Department"]['@attributes'])
                  
                    )
                    {
                        //  dd($departments["Department"]['@attributes']['id']);
                        // dd($departments['@attributes']);
                        // var_dump($LesVersions['Categories']['Item']);
                        // dd($LesVersions['Region']['Country']['@attributes']['name']); && array_key_exists(0, $LesVersions['Categories']['Item'])
                        //  dd($LesVersions['Region']['Country']['County']);
                        //print_r($LesVersions);
                        array_push($jobs, new Job($attributes['id'], $attributes['date_start'], $attributes['date_end'],
                        $attributes['reference_number'], $LesVersions['Title'], $LesVersions['TitleHeading'], 
                        $LesVersions['AlternativeCompanyName'], $LesVersions['Location'], $LesVersions['Region']['Country']['County'], 
                        $LesVersions['Categories']['Item'], $departments["Department"]['@attributes']['id'],
                        $departments["Department"]['LogoURL'], $departments["Department"]['ImageURL'],
                        $departments["Department"]['VacancyURL'], $departments["Department"]['ApplicationURL']));
                    }   

                }
            //     if($dataLangues['language'] == "fr") {
                    //  dd($dataLangues['language']);
                    // if(is_array($versions['Title'])){
                    //     dd($versions, $count);
                    // }
    //                 array_push($jobs, new Job($attributes['id'], $attributes['date_start'], $attributes['date_end'],
    //                 $attributes['reference_number']
    //              //    $versions['Region'],  $versions['Categories']
    // ));

                    //  dd( $versions['Title']);$versions['ApplicationDeadline'], $versions['Engagement'], $versions['DailyHours']
                // }
    
                // }

             
            //  dd($attributes);
            // $versions = ($ofres["Versions"]);
            // foreach($versions['Version'] as $version){
            //     dd($version);
            //}
           
        }

        
//  dd($jobs);

        return view("job", compact("jobs"));
    }


}
