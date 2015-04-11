<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Comment
 *
 * @ORM\Table(name="comment")
 * @ORM\Entity
 */
class Comment
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     * @Assert\NotBlank(message="Proszę wprowadzić treść komentarza")
     * @Assert\Length(min=15, minMessage="Minimalna długość komentarza to: {{ limit }}) znaków")
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     * @Assert\NotBlank()
     */
    private $createdAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbVoteUp", type="smallint")
     */
    private $nbVoteUp = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbVoteDown", type="smallint")
     */
    private $nbVoteDown = 0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="verified", type="boolean")
     */
    private $verified = FALSE;
    
    /**
     *
     * @var ArrayCollection
     * 
     * @ORM\ManyToOne(targetEntity="product", inversedBy="comments")
     */
    private $product;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Comment
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Comment
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set nbVoteUp
     *
     * @param integer $nbVoteUp
     * @return Comment
     */
    public function setNbVoteUp($nbVoteUp)
    {
        $this->nbVoteUp = $nbVoteUp;

        return $this;
    }

    /**
     * Get nbVoteUp
     *
     * @return integer 
     */
    public function getNbVoteUp()
    {
        return $this->nbVoteUp;
    }

    /**
     * Set nbVoteDown
     *
     * @param integer $nbVoteDown
     * @return Comment
     */
    public function setNbVoteDown($nbVoteDown)
    {
        $this->nbVoteDown = $nbVoteDown;

        return $this;
    }

    /**
     * Get nbVoteDown
     *
     * @return integer 
     */
    public function getNbVoteDown()
    {
        return $this->nbVoteDown;
    }

    /**
     * Set verified
     *
     * @param boolean $verified
     * @return Comment
     */
    public function setVerified($verified)
    {
        $this->verified = $verified;

        return $this;
    }

    /**
     * Get verified
     *
     * @return boolean 
     */
    public function getVerified()
    {
        return $this->verified;
    }

    /**
     * Set product
     *
     * @param \AppBundle\Entity\product $product
     * @return Comment
     */
    public function setProduct(\AppBundle\Entity\product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \AppBundle\Entity\product 
     */
    public function getProduct()
    {
        return $this->product;
    }
}