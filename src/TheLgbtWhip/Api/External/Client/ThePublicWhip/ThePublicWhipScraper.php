<?php
namespace TheLgbtWhip\Api\External\Client\ThePublicWhip;

use DOMImplementation;
use DOMNodeList;
use DOMXPath;



/**
 * Description of ThePublicWhipScraper
 *
 * @author matt
 */
class ThePublicWhipScraper
{
    
    /**
     *
     * @var DomImplementation
     */
    protected $domImplementation;
    
    
    
    /**
     * 
     * @param DOMImplementation $domImplementation
     */
    public function __construct(DOMImplementation $domImplementation)
    {
        $this->domImplementation = $domImplementation;
    }
    
    /**
     * 
     * @param string $html
     * @return array
     */
    public function parse($html)
    {
        $start = strpos($html, '<table class="votes" id="votetable">');
        $end = strpos($html, '</table>') - $start + 8;

        if ($start === false || $end === false) {
            return null;
        }

        $htmlFragment = str_replace("&", "&amp;", substr($html, $start, $end));

        $dom = $this->domImplementation->createDocument();
        $dom->loadHTML("<html><body>{$htmlFragment}</body></html>");
        
        $xpath = new DOMXPath($dom);
        
        return $this->processVotingTable($xpath);
    }
    
    /**
     * 
     * @param DOMXPath $xpath
     * @return array
     */
    protected function processVotingTable(DOMXPath $xpath)
    {
        $votes = [];
        
        foreach ($xpath->query("//tr[not(contains(@class, 'heading'))]") as $rowElement) {
            $nameElements = $xpath->query("./td[1]/a[1]", $rowElement);
            $constituencyElements = $xpath->query("./td[2]/a[1]", $rowElement);
            $voteElements = $xpath->query("./td[4]", $rowElement);

            foreach ([$nameElements, $constituencyElements, $voteElements] as $elements) {
                if ($elements->length < 1) {
                    continue 2;
                }
            }
            
            $name = $this->convertNameString($nameElements);
            
            $votes[$name] = [
                ThePublicWhipProcessorInterface::VOTE_DATA_KEY_NAME         =>  $name,
                ThePublicWhipProcessorInterface::VOTE_DATA_KEY_CONSTITUENCY =>  trim($constituencyElements->item(0)->nodeValue),
                ThePublicWhipProcessorInterface::VOTE_DATA_KEY_VOTE_CAST    =>  $voteElements->item(0)->nodeValue
            ];
        }
        
        return $votes;
    }
    
    /**
     * 
     * @param DOMNodeList $nameElements
     * @return string
     */
    protected function convertNameString(DOMNodeList $nameElements)
    {
        return preg_replace(
            '#^(?:(?:Mr)|(?:Mrs)|(?:Ms)|(?:Miss)|(?:Sir))\.?\s(.+)$#i',
            '\1',
            trim($nameElements->item(0)->nodeValue)
        );
    }
    
}
