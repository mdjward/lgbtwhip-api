<?php
namespace TheLgbtWhip\Api\External\Client\ThePublicWhip;

use DOMImplementation;
use DOMXPath;
use TheLgbtWhip\Api\External\Client\VotedNameFormatter;



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
     * @var VotedNameFormatter
     */
    protected $votedNameFormatter;
    
    
    
    /**
     * 
     * @param DOMImplementation $domImplementation
     * @param VotedNameFormatter $votedNameFormatter
     */
    public function __construct(
        DOMImplementation $domImplementation,
        VotedNameFormatter $votedNameFormatter
    ) {
        $this->domImplementation = $domImplementation;
        $this->votedNameFormatter = $votedNameFormatter;
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
            throw new ThePublicWhipScraperException(
                'Unable to locate voting stats table on scraped resource'
            );
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
            
            $name = $this->votedNameFormatter->convertNameString(
                $nameElements->item(0)->nodeValue
            );
            
            $constituency = trim($constituencyElements->item(0)->nodeValue);
            
            $votes[$name . ' - ' . $constituency] = [
                ThePublicWhipProcessorInterface::VOTE_DATA_KEY_NAME         =>  $name,
                ThePublicWhipProcessorInterface::VOTE_DATA_KEY_CONSTITUENCY =>  $constituency,
                ThePublicWhipProcessorInterface::VOTE_DATA_KEY_VOTE_CAST    =>  $voteElements->item(0)->nodeValue
            ];
        }
        
        return $votes;
    }
    
}
