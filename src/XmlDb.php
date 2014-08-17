<?php

/**
 * Copyright (c) 2014 Jeremy Sells
 * For copying permission, copyright information, terms, etc read the
 * LICENSE (file) that that was distributed with this source code.
 */

namespace JeremySells\XmlDb;

/**
 * Xml database abstraction. Can be extended.
 */
class XmlDb implements Interfaces\XmlDb
{
    /**
     * Lazy init, the DOM document
     * @var \DOMDocument
     */
    protected $domDocument;
    
    /**
     * Lazy init, the DOM xPath
     * @var \DOMXPath
     */
    protected $xPath;
    
    /**
     * The path and fil to save the file to
     * @var string
     */
    protected $saveFile;
    
    /**
     * Setting, make save directory if it does not exist
     * @var boolean 
     */
    protected $saveMkdir;
    
    /**
     * The xml file to load
     * @var string
     */
    protected $loadFile;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->saveFile = null;
        $this->loadFile = null;
        $this->saveMkdir = true;
        $this->domDocument = null;
        $this->xPath = null;
    }
    
    /**
     * Sets the same file
     * 
     * @param string $saveFile
     * 
     * @return void
     */
    public function setSaveFile($saveFile)
    {
        $this->saveFile = $saveFile;
    }

    /**
     * Sets the load file
     * 
     * @param string $loadFile
     * 
     * @return void
     */
    public function setLoadFile($loadFile)
    {
        $this->loadFile = $loadFile;
    }

    /**
     * Sets if we should make the save dir, if it does not exist
     * 
     * @param boolean $saveMkdir
     * 
     * @return void
     */
    public function setSaveMkdir($saveMkdir)
    {
        $this->saveMkdir = $saveMkdir;
    }
        
    /**
     * Gets the dom
     * 
     * @return \DOMDocument
     * @throws \Exception
     */
    public function getDom()
    {
        if ($this->loadFile === null) {
            throw new \Exception("Invalid load file");
        }
        if ($this->domDocument === null) {
            $this->domDocument = new \DOMDocument();
            if ($this->loadFile !== null) {
                $result = $this->domDocument->load($this->loadFile);
                if (!$result) {
                    throw new \Exception(
                        "Failed to open xml file ".$this->loadFile
                    );
                }
            }
        }
        return $this->domDocument;
    }

    /**
     * Gets the xpath
     * 
     * @return \DOMXPath
     */
    public function getXPath()
    {
        if ($this->xPath === null) {
            $this->xPath = new \DOMXPath($this->getDom());
        }
        return $this->xPath;
    }
    
    /**
     * Prefixes (replaces) single quotes with slash ("'" -> "\'")
     * http://php.net/manual/en/simplexmlelement.xpath.php#106361
     * @param string $value
     * @return string
     */
    public function slashQuote($value)
    {
        return str_replace("'", "\'", $value);
    }
    
    /**
     * Prefixes (replaces) double quotes with slash ('"' -> '\"')
     * @param string $value
     * @return string
     */
    public function slashQuotes($value)
    {
        return str_replace('"', '\"', $value);
    }
    
    /**
     * Runs an xpath query
     * @param string $xpathExpression
     * @return DOMNodeList
     * @throws Exception
     */
    public function query($xpathExpression)
    {
        $xpath = $this->getXPath();
        $result = $xpath->query($xpathExpression);
        if ($result === false || $result === null) {
            throw new Exception("Bad xpath query of ".$xpath);
        }
        return $result;
    }
    
    /**
     * Clears all data
     * 
     * @return void
     */
    public function clear()
    {
        $this->domDocument = new \DOMDocument();
        $this->xPath = null;
    }

    /**
     * Saves to file
     * Returns a boolean if it was successful
     * 
     * @return boolean
     * 
     * @throws \Exception
     */
    public function save()
    {
        if ($this->saveFile === null || trim($this->saveFile) === "") {
            throw new Exception("Save path was not set");
        }
        if ($this->saveMkdir) {
            $writeParts = pathinfo($this->saveFile);
            $dir = $writeParts['dirname'];
            if (!is_dir($dir) && !mkdir($dir, 0770, true)) {
                throw new \Exception("Unable to make directory ".$dir);
            }
        }
        $result = $this->getDom()->save($this->saveFile);
        return ($result > 0);
    }
}
