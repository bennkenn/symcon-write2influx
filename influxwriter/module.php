<?php
    // Klassendefinition
    class influxwriter extends IPSModule {

        // Überschreibt die interne IPS_Create($id) Funktion
        public function Create() {
            // Diese Zeile nicht löschen.
            parent::Create();

        }

        // Überschreibt die intere IPS_ApplyChanges($id) Funktion
        public function ApplyChanges() {
            // Diese Zeile nicht löschen
            parent::ApplyChanges();
        }

        /**
        * Die folgenden Funktionen stehen automatisch zur Verfügung, wenn das Modul über die "Module Control" eingefügt wurden.
        * Die Funktionen werden, mit dem selbst eingerichteten Prefix, in PHP und JSON-RPC wiefolgt zur Verfügung gestellt:
        *
        * ABC_MeineErsteEigeneFunktion($id);
        *
        */
        public function MeineErsteEigeneFunktion() {
            // Selbsterstellter Code
        }

        public function write2Influx($id, $host, $port, $db, $system, $category, $valuename){
        $out ='http://'.$host.':'.$port.'/write?db='.$db.'';

        $ch = curl_init($out);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_POST,           1 );

        $vartype = IPS_GetVariableCompatibility($id)['VariableType'];
        /*0: Boolean, 1: Integer, 2: Float, 3: String*/
        //echo $vartype.' ';
        switch ($vartype){

        case 0:
        $value = GetValueBoolean($id) ;
        if ($value == true){
        curl_setopt($ch, CURLOPT_POSTFIELDS,     $system.','.$category.'='.$valuename.' value=1');
        }
        else{
        curl_setopt($ch, CURLOPT_POSTFIELDS,     $system.','.$category.'='.$valuename.' value=0');
        }
        //echo 'es war ein bool ';
        break;

        case 1:
        $value = GetValueInteger($id) ;
        curl_setopt($ch, CURLOPT_POSTFIELDS,     $system.','.$category.'='.$valuename.' value=' .$value);
        break;

        case 2:
        $value = GetValueFloat($id) ;
        curl_setopt($ch, CURLOPT_POSTFIELDS,     $system.','.$category.'='.$valuename.' value=' .  number_format($value/1,1,'.','') );
        //echo 'es war ein float ';
        break;

        }

        $result=curl_exec ($ch);
        $error=curl_error($ch) ;

        echo $result ;
        echo $error ;
        //echo $system.','.$category.'='.$valuename.' value=' .  number_format($floatvalue/1,1,'.','');
        }
    }
