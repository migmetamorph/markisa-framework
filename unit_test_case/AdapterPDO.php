<?php

/* 
 * 
 * File Name    :
 * Framework    :
 * Version      :
 * Author       :
 * Updated      : 
 * 
 * 
 * Description
 * 
 * 
 * Changelog
 * 
 * 
 */

abstract class AdapterPDO{
    
    /* 
     * 
     * Register object 
     * 
     */
    protected $oDriver = false;
    /* 
     * Register specific host parameter 
     */
    protected $dbms;
    
    protected $encoding;
    protected $protocol;
    protected $port;
    
    protected $host;
    protected $user;
    protected $pass;
    protected $database;
    /* 
     * Register specific PDO parameter 
     */
    protected $dsn;
    protected $option = false;
    /* 
     * Register dsn setup
     */
    protected $sDatabase;
    protected $sHost;
    protected $sProtocol;
    /* 
     * Processing database
     */
    protected $query;
    
    
    
    /* 
     * Register DBMS parameter
     */
    protected $propDB = array('IBM'=>     array('db'=>'DATABASE',
                                             'host'=>'HOSTNAME'),
                           'OCI'=>     array('db'=>'dbname',
                                             'host'=>'host'),
                           'MYSQL'=>   array('db'=>'dbname',
                                             'host'=>'host'),
                           'SQLSRV'=>  array('db'=>'Database',
                                             'host'=>'Server'),
                           'PGSQL'=>   array('db'=>'dbname',
                                             'host'=>'host'));
    
    
    public function AdapterPDO($config){
            
            if(!empty($config['dbms'])){
                
                if(empty($config['encoding'])){
                    $this->encoding = 'UTF-8';
                }else{
                        $this->encoding = $config['encoding'];
                    }
                
                $this->dbms     = strtoupper($config['dbms']);
                $this->host     = $config['host'];
                $this->database = $config['dbname'];
                $this->port     = $config['port'];
                $this->protocol = $config['protocol'];
                
                $this->user     = $config['username'];
                $this->pass     = $config['password'];
                $this->option   = $config['option'];
                
                $this->dsn  = strtolower($this->dbms).':';
                
                if($this->dbms === 'OCI'){
                        $this->sHost = $this->host.'/'.$this->database.';charset:'.$this->encoding.';';
                    }else{
                            if($this->dbms === 'IBM'){
                                    $this->sDatabase = 'DRIVER={IBM DB2 ODBC DRIVER};'.$this->propDB[$this->dbms]['db'].'='.$this->database.';';
                                        $this->sProtocol = 'PORT='.$this->port.';PROTOCOL='.$this->protocol.';';
                                }else{
                                        $this->sDatabase = $this->propDB[$this->dbms]['db'].'='.$this->database.';';
                                    }
                                    
                            $this->sHost = $this->propDB[$this->dbms]['db'].'='.$this->host.';';
                            
                        }
                            
                switch($this->dbms){
                    case 'IBM'  :
                                    $this->dsn .= $this->sDatabase;
                                        $this->dsn .= $this->sHost;
                                            $this->dsn .= $this->sProtocol;
                                            
                                    break;
                    case 'OCI'  :
                                    $this->dsn .= $this->sHost;
                                        break;
                    case 'MYSQL':
                                    $this->dsn .= $this->sHost;
                                        $this->dsn .= $this->sDatabase;
                                    break;
                    case 'MSSQL':
                                    $this->dsn .= $this->sHost;
                                        $this->dsn .= $this->sDatabase;
                                    break;
                    case 'PGSQL':
                                    $this->dsn .= $this->sDatabase;
                                            $this->dsn .= $this->sHost;
                                    break;
                    default     :
                                    $this->dsn = false;
                                        break;
                }
            
                    
            }
                
            if($this->dsn){
                    return $this->connect();
                }
                
                return $this->dsn;
                    
        }
        
        public function connect(){
                
                if($this->option){
                        $this->oDriver =& new PDO($this->dsn, $this->user, $this->pass, $this->option);
                    }else{
                            $this->oDriver =& new PDO($this->dsn, $this->user, $this->pass);
                        }
                        
                if(is_object($this->oDriver)){
                        return $this->oDriver;
                    }
                    
                    return false;
                
            }
            
        protected function pop($sql){
                    
                if(!$this->oDriver){
                            return false;
                        }
                        
                    $this->query = $this->oDriver->prepare($sql);
                    
                    if(!$this->query->execute()){
                            return false;
                        }
                        
                        return $this->query->fetchAll();
                        
            }
            
        protected function push($sql){
                    
                if(!$this->oDriver){
                            return false;
                        }
                        
                    if($this->oDriver->exec($sql)>0){
                            return true;
                        }
                        
                        return false;
                        
            }
        
}

class singleAdapterPDO extends AdapterPDO{
    }

?>
