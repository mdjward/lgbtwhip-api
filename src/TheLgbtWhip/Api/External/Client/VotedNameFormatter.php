<?php
/**
 * VotedNameFormatter.php
 * Definition of class VotedNameFormatter
 * 
 * Created 27-Apr-2015 00:15:22
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\External\Client;



/**
 * VotedNameFormatter
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class VotedNameFormatter
{
    
    /**
     * 
     * @param string $name
     * @return string
     */
    public function convertNameString($name)
    {
        return preg_replace(
            '#^(?:(?:Prof)|(?:Dr)|(?:Mr)|(?:Mrs)|(?:Ms)|(?:Miss)|(?:Sir))\.?\s(.+)$#i',
            '\1',
            trim($name)
        );
    }
    
}
