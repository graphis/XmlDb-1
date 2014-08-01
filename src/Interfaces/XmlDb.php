<?php

/**
 * Copyright (c) 2014 Jeremy Sells
 * For copying permission, copyright information, terms, etc read the
 * LICENSE (file) that that was distributed with this source code.
 */

namespace JeremySells\XmlDb\Interfaces;

/**
 * Xml database abstraction interface
 */
interface XmlDb
{
    /**
     * Sets the same file
     * 
     * @param string $saveFile
     * 
     * @return void
     */
    public function setSaveFile($saveFile);

    /**
     * Sets the load file
     * 
     * @param string $loadFile
     * 
     * @return void
     */
    public function setLoadFile($loadFile);

    /**
     * Sets if we should make the save dir, if it does not exist
     * 
     * @param boolean $saveMkdir
     * 
     * @return void
     */
    public function setSaveMkdir($saveMkdir);
    
    /**
     * Gets the dom
     * 
     * @return \DOMDocument
     */
    public function getDom();

    /**
     * Gets the xpath
     * 
     * @return \DOMXPath
     */
    public function getXPath();

    /**
     * Clears all data
     * 
     * @return void
     */
    public function clear();

    /**
     * Saves to file
     * Returns a boolean if it was successful
     * 
     * @return boolean
     * 
     * @throws \Exception
     */
    public function save();
}
