<?php
    // Klassendefinition
    class influxwriter extends IPSModule {

        // Überschreibt die interne IPS_Create($id) Funktion
        public function Create() {
            // Diese Zeile nicht löschen.
            parent::Create();
            //$this->RegisterVariableString("SymconVersion", "Symcon Version");
            $this->RegisterPropertyString("influxDbServerIP", "192.168.78.55");
            $this->RegisterPropertyString("influxDbServerPort", "8086");
            $this->RegisterPropertyString("influxDbServerDB", "symcon");
               
        }

        // Überschreibt die intere IPS_ApplyChanges($id) Funktion
        public function ApplyChanges() {
            // Diese Zeile nicht löschen
            parent::ApplyChanges();

            //$this->SetValue("SymconVersion", IPS_GetKernelVersion());
            
            
        }

        /**
        * Die folgenden Funktionen stehen automatisch zur Verfügung, wenn das Modul über die "Module Control" eingefügt wurden.
        * Die Funktionen werden, mit dem selbst eingerichteten Prefix, in PHP und JSON-RPC wiefolgt zur Verfügung gestellt:
        *
        * ABC_MeineErsteEigeneFunktion($id);
        *
        */

        //public function write2Influx($id, $host, $port, $db, $system, $category, $valuename){
        public function write2Influx($id, $system, $category, $valuename){
        
        $host = IPS_GetProperty($this->InstanceID, "influxDbServerIP");
        $port = IPS_GetProperty($this->InstanceID, "influxDbServerPort");
        $db = IPS_GetProperty($this->InstanceID, "influxDbServerDB");
        
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

        /*case 3:
            $value = GetValueString($id) ;
            //echo $value;
            $intValue = intval($value);
            //echo $intValue;
            curl_setopt($ch, CURLOPT_POSTFIELDS,     $system.','.$category.'='.$valuename.' value=' .$intValue);
            //echo 'es war ein string und wurde in int convertiert ';
            break;
        */
        }

        $result=curl_exec ($ch);
        $error=curl_error($ch) ;

        echo $result ;
        echo $error ;
        //echo $system.','.$category.'='.$valuename.' value=' .  number_format($floatvalue/1,1,'.','');
        }
    }
