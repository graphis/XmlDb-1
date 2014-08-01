<?php

/**
 * Copyright (c) 2014 Jeremy Sells
 * For copying permission, copyright information, terms, etc read the
 * LICENSE (file) that that was distributed with this source code.
 */

namespace JeremySells\XmlDb\Factories;

use JeremySells\XmlDb;

/**
 * Xml database factory
 */
class XmlDb
{
    /**
     * New Read only Database load path
     * @param string $loadPath
     * @return \JeremySells\XmlDb\XmlDb
     */
    public static function newReadXmldb($loadPath)
    {
        $xmlDb = new XmlDb\XmlDb();
        $xmlDb->setLoadFile($loadPath);
        return $xmlDb;
    }
    
    /**
     * New Xml Database with save and load path
     * @param string $loadPath
     * @param string $savePath
     * @return \JeremySells\XmlDb\XmlDb
     */
    public static function newXmlDb($loadPath, $savePath)
    {
        $xmlDb = new XmlDb\XmlDb();
        $xmlDb->setLoadFile($loadPath);
        $xmlDb->setSaveFile($savePath);
        return $xmlDb;
    }
}
