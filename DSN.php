<?php

/**
 * Use this class in your code to connect as declarer 
 * into DSN API services
 */
class DSN{
    
    /**
     * Token of connection to the DSN API
     * This token will be expire in one hour
     */
    private $token;

    public function DSN($siret, $lastname, $firstname, $password){
        $payload = '<identifiants>
                        <siret>' . $siret  . '</siret>
                        <nom>' . $lastname . '</nom>
                        <prenom>' . $firstname . '</prenom>
                        <motdepasse>' . $password . '</motdepasse>
                        <service>25</service>
                    </identifiants>';
        
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, URL::auth );
        curl_setopt( $ch, CURLOPT_POST, true );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        $this->token = curl_exec($ch);
        curl_close($ch);
    }

    public function deposits($dateStart, $dateStop){
        $auth = 'DSNLogin jeton=' . $this->token;
                    
        $uri = URL::deposit . responseType::xml . '/' . $dateStart . '/' . $dateStop;
            
            $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $uri);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: ' . $auth));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING , '');
        curl_setopt($ch, CURLOPT_FORBID_REUSE, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    public function feeds($id){        
        $auth = 'DSNLogin jeton=' . $this->token;
        
        $url = URL::feed . responseType::xml . '/' . $id;
        
        $ch = curl_init();
        curl_reset($ch);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: ' . $auth));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, False);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, False);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, True); 
        $rs = curl_exec($ch);
        if($rs)
            $data = $this->unzip($rs);    
          
        return $data;
    }

    public function crm($url){
        $auth = 'DSNLogin jeton=' . $this->token;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: ' . $auth));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING , '');
        curl_setopt($ch, CURLOPT_FORBID_REUSE, true);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    private function unzip($zipped) {
        $offset = 0;
        if (substr($zipped, 0, 2) == "\x1f\x8b")
            $offset = 2;
        if (substr($zipped, $offset, 1) == "\x08")  {
            return gzinflate(
                substr($zipped, $offset + 8)
            );
        }
        return "N/D";
    }
}

/**
 *  All urls are in production mode.
 */
abstract class URL{
	const auth = 'https://services.net-entreprises.fr/authentifier/1.0/';
	const deposit = 'https://consultation.dsnrg.net-entreprises.fr/lister-depots/';
	const feed = 'https://consultation.dsnrg.net-entreprises.fr/lister-retours-flux/';
}

abstract class responseType{
	const __default = self::xml;
	const xml = '1.0';
	const json = '2.0';
}