<?php

namespace common\models;
use Yii;
/*Helper class for Navision
/*David Komen
/*
*/
//--//@#8!Cu3@aP
//--//@#8!Cu3@aP//
class Services
{

    private $Server = null;
    private $Port = null;
    private $ServerInstance = null;
    private $CompanyName = null;
    private $ServiceName = null;
    private $id=null;
    private $url=null;
    public function __construct($id)
    {
        $this->id=$id;
    }
    function __destruct()
    {

    }
    public function getServer()
    {
        if ( isset(Yii::$app->params['server']) )
        {
            $this->Server= Yii::$app->params['server'];
            return $this->Server;
        }

    }
    public  function getPort()
    {
        if ( isset(Yii::$app->params['WebServicePort']) )
        {
            $this->Port= Yii::$app->params['WebServicePort'];
            return $this->Port;
        }

    }
    public  function getServerInstance()
    {
        if ( isset(Yii::$app->params['ServerInstance']) )
        {
            $this->ServerInstance= Yii::$app->params['ServerInstance'];
            return $this->ServerInstance;
        }

    }
    public function getCompanyName()
    {
        if ( isset(Yii::$app->params['CompanyName']) )
        {
            $this->CompanyName= Yii::$app->params['CompanyName'];
            return $this->CompanyName;
        }

    }

    public function getServiceName()
    {
        if ( isset(Yii::$app->params['ServiceName']))
        {
            $serviceNames=Yii::$app->params['ServiceName'];//FMN: AN array of web service identities set in params.php in config dir.
            if(array_key_exists("$this->id",$serviceNames)){//FMN: $this->id is a class argument representing index of the requested service
                $this->ServiceName= $serviceNames[$this->id];
            }
            return  $this->ServiceName;
        }
    }
    public function getUrl()
    {
        if($this->getServer() && $this->getPort() && $this->getServiceName() && $this->getCompanyName() && $this->getServiceName() && $this->getServerInstance())
        {
            $this->url='http://'.$this->Server.':'.$this->Port.'/'.$this->ServerInstance.'/WS/'.$this->CompanyName.'/Page/'.$this->ServiceName;
            if(in_array($this->id, Yii::$app->params['codeUnits']))// any id in codeunits array be considered as a codeunit WS
            {
                $this->url='http://'.$this->Server.':'.$this->Port.'/'.$this->ServerInstance.'/WS/'.$this->CompanyName.'/Codeunit/'.$this->ServiceName;
            }
            return $this->url;
        }
        else
        {
            //return 'Could not construct url';
            return false;
        }

    }
    public function isUp()
    {
        //Get Nav service status
        if($this->getUrl()&& filter_var($this->getUrl(), FILTER_VALIDATE_URL))//constructs and validates url/service url
        {
            $url = $this->getUrl();
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_NOBODY, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch, CURLOPT_TIMEOUT,10);
            $output = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if(($httpcode == "200" ) || ( $httpcode == "302" )|| ( $httpcode == "401" )){
                return true;
            }else{
                return false;
            }
        }
        //Navision is down
        //Url malformed
        return false;
    }

}