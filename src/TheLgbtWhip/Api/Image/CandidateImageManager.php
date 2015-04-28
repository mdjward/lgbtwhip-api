<?php
/**
 * CandidateImageManager.php
 * Definition of class CandidateImageManager
 * 
 * Created 28-Apr-2015 09:48:16
 *
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 * @copyright (c) 2015, Byng Systems Ltd
 */
namespace TheLgbtWhip\Api\Image;

use Gregwar\Image\Image;
use TheLgbtWhip\Api\Manager\CandidateManager;
use TheLgbtWhip\Api\Model\Candidate;



/**
 * CandidateImageManager
 * 
 * @author M.D.Ward <matthew.ward@byng-systems.com>
 */
class CandidateImageManager
{

    /**
     * 
     */
    const BASE64_REGEX = '#^data:image\/[^;]+;[^,]+,#';
    
    /**
     *
     * @var CandidateManager
     */
    protected $candidateManager;

    /**
     *
     * @var Image 
     */
    protected $imageProcessor;

    /**
     *
     * @var callable
     */
    protected $base64DecodeCallback;

    
    
    /**
     * 
     * @param CandidateManager $candidateManager
     * @param Image $imageProcessor
     * @param callable $base64DecodeCallback
     */
    public function __construct(
        CandidateManager $candidateManager,
        Image $imageProcessor,
        callable $base64DecodeCallback
    ) {
        $this->candidateManager = $candidateManager;
        $this->imageProcessor = $imageProcessor;
        $this->base64DecodeCallback = $base64DecodeCallback;
    }

    /**
     * 
     * @param Candidate $candidate
     * @return ImageResponseWrapper
     * @throws NoImageException
     */
    public function loadImageForCandidate(Candidate $candidate)
    {
        $base64Image = $candidate->getPhoto();
        
        if (is_resource($base64Image)) {
            $base64Image = stream_get_contents($base64Image);
        }
        
        if (empty($base64Image)) {
            throw new NoImageException($candidate);
        }
        
        $this->imageProcessor->setData(
            call_user_func(
                $this->base64DecodeCallback,
                preg_replace(self::BASE64_REGEX, '', $base64Image)
            )
        );
        
        return new ImageResponseWrapper(
            $this->imageProcessor->guessType(),
            $this->imageProcessor->get('guess', 100)
        );
    }

    /**
     * 
     * @param Candidate $candidate
     * @param mixed $imageData
     * @return ImageResponseWrapper
     */
    public function setImageForCandidate(Candidate $candidate, $imageData)
    {
        $this->imageProcessor->setData($imageData);

        $this->candidateManager->saveCandidate(
            $candidate->setPhoto(
                $this->imageProcessor->inline(
                    $this->imageProcessor->guessType(),
                    100
                )
            ),
            true
        );

        return $this->loadImageForCandidate($candidate);
    }

}
