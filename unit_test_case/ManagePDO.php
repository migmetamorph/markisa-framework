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
class managePDO extends AdapterPDO{
    
        protected $sTable;
        protected $sField;
        protected $sEntry;
        protected $sCondition;
        protected $sPointer;
        protected $sSeekPointer;
        
        protected $sBufer = array();
        
        protected $sDistinct;
        protected $sJoin;
        protected $sSort;
        
        protected $statement;
        
        protected function AdapterPDO(){
                $this->sBufer = array('table', 'field', 'entry', 'condition');
            }

        public function parseBinding(){
                
                $this->sSeekPointer = 0;
                
                if(isset($this->sBufer['table']) && is_array($this->sBufer['table'])){
                        $this->sPointer = count($this->sBufer['table']);
                        
                        foreach($this->sBufer['table'] as $entry){
                                if($this->sSeekPointer > $this->sPointer){
                                        $this->sTable = $this->sBufer['table'].', '; 
                                    }else{
                                            $this->sTable = $this->sBufer['table'];
                                        }
                            }
                            
                    }
                    
                if(isset($this->sBufer['field'])){

                    if(is_array($this->sBufer['field'])){
                                
                                $this->sPointer = count($this->sBufer['field']);
                                
                                foreach($this->sBufer['field'] as $entry){
                                
                                if($this->sSeekPointer > $this->sPointer){
                                            $this->sField = $this->sBufer['field'].', '; 
                                        }else{
                                                $this->sField = $this->sBufer['field'];
                                            }
                                    }
                            }else{
                                    $this->sField = $this->sBufer['field'];
                                }
                                
                    }else{
                            $this->sField = '*';
                        }
                    
                if(isset($this->sBufer['entry']) && is_array($this->sBufer['entry'])){
                        
                        $this->sPointer = count($this->sBufer['entry']);
                        
                        foreach($this->sBufer['entry'] as $entry){
                                if($this->sSeekPointer > $this->sPointer){
                                        $this->sTable = $this->sBufer['entry'].', '; 
                                    }else{
                                            $this->sTable = $this->sBufer['entry'];
                                        }
                            }
                            
                    }
                    
                if(isset($this->sBufer['condition']) && is_array($this->sBufer['condition'])){
                        
                        $this->sPointer = count($this->sBufer['condition']);
                        
                        foreach($this->sBufer['condition'] as $entry){
                                if($this->sSeekPointer > $this->sPointer){
                                        $this->sTable = $this->sBufer['condition'].', '; 
                                    }else{
                                            $this->sTable = $this->sBufer['condition'];
                                        }
                            }
                            
                    }
                    
                if(isset($this->sBufer['join']) && is_array($this->sBufer['join'])){
                        
                        $this->sPointer = count($this->sBufer['join']);
                        
                        foreach($this->sBufer['join'] as $entry){
                                if($this->sSeekPointer > $this->sPointer){
                                        $this->sTable = $this->sBufer['join'].', '; 
                                    }else{
                                            $this->sTable = $this->sBufer['join'];
                                        }
                            }
                            
                    }
                    
                 if(isset($this->sBufer['join_condition']) && is_array($this->sBufer['join_condition'])){
                        
                        $this->sPointer = count($this->sBufer['join_condition']);
                        
                        foreach($this->sBufer['join_condition'] as $entry){
                                if($this->sSeekPointer > $this->sPointer){
                                        $this->sTable = $this->sBufer['join_condition'].', '; 
                                    }else{
                                            $this->sTable = $this->sBufer['join_condition'];
                                        }
                            }
                            
                    }
                    
            }
            
            protected function parseProp($key, $value){
                    $this->sBufer[$key][] = $value;
                }
                
            protected function exclusive($distinct, $join, $mode, $sort, $inverse_sort){
                    
                    $this->sDistinct= 'DISTINCT';
                    
                    if(isset($this->sBufer['join'])){
                            $this->parseBinding();
                                $this->sJoin = $mode.' '.$this->sBufer['join'].' ON '.$this->sBufer['join_condition'];
                        }
                    
                    $this->sSort = 'SORT BY '.$sort;
                    
                    if($inverse_sort){
                            $this->sSort .= 'DESC';
                        }
                    
                }
            
            protected function insert(){
                    if(isset($this->sBufer['table']) && isset($this->sBufer['field'])){
                            
                        }
                }
                
            protected function select(){
                
                    $this->parseBinding();
                    
                    if(isset($this->sBufer['table']) && isset($this->sBufer['field'])){
                            
                            $this->statement = 'SELECT ';
                            
                            if($this->sDistinct){
                                    $this->statement .= $this->sDistinct.' '.$this->sField;
                                }
                            
                                $this->statement .= ' FROM '.$this->sTable.' ';
                            
                            if($this->sBufer['join']){
                                    $this->statement .= $this->sJoin;
                                }
                                
                            if(isset($this->sBufer['condition'])){
                                    $this->statement .= ' WHERE '.$this->sCondition.' '.$this->sSort;
                                }    
                            
                                
                            parent::pop($this->statement);
                                
                        } 
                    
                    return false;
                    
                }
                
            protected function count(){
                }
                
            protected function update(){
                }
                
            protected function delete(){
                }
        
        
        
    }

?>
