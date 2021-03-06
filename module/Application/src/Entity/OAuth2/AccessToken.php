<?php

namespace Application\Entity\OAuth2;

use Laminas\Stdlib\ArraySerializableInterface;
use ApiSkeletons\OAuth2\Doctrine\Entity\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * AccessToken
 * @ORM\Table(name="oauth_access_token")
 * @ORM\Entity
 */
class AccessToken implements ArraySerializableInterface
{
    /**
     * @var string
     * @ORM\Column(name="access_token", type="text", nullable=true)
     */
    private $accessToken;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    private $expires;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Client
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="accessToken")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $client;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="Scope", mappedBy="accessToken")
     */
    private $scope;

    /**
     * UserInterface
     * @var object
     */
    private $user;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->scope = new ArrayCollection();
    }

    public function getArrayCopy()
    {
        return array(
            'id' => $this->getId(),
            'accessToken' => $this->getAccessToken(),
            'expires' => $this->getExpires(),
            'client' => $this->getClient(),
            'scope' => $this->getScope(),
            'user' => $this->getUser(),
        );
    }

    public function exchangeArray(array $array)
    {
        foreach ($array as $key => $value) {
            switch ($key) {
                case 'accessToken':
                    $this->setAccessToken($value);
                    break;
                case 'expires':
                    $this->setExpires($value);
                    break;
                case 'client':
                    $this->setClient($value);
                    break;
                case 'scope':
                    // Clear old collection
                    foreach ($value as $remove) {
                        $this->removeScope($remove);
                        $remove->removeAccessToken($this);
                    }

                    // Add new collection
                    foreach ($value as $scope) {
                        $this->addScope($scope);
                        $scope->addAccessToken($this);
                    }
                    break;
                case 'user':
                    $this->setUser($value);
                    break;
                default:
                    break;
            }
        }

        return $this;
    }

    /**
     * Set accessToken
     *
     * @param string $accessToken
     * @return AccessToken
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * Get accessToken
     *
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Set expires
     *
     * @param \DateTime $expires
     * @return AccessToken
     */
    public function setExpires($expires)
    {
        $this->expires = $expires;

        return $this;
    }

    /**
     * Get expires
     *
     * @return \DateTime
     */
    public function getExpires()
    {
        return $this->expires;
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
     * Set client
     *
     * @param Client $client
     * @return AccessToken
     */
    public function setClient(?Client $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Add scope
     *
     * @param Scope $scope
     * @return AccessToken
     */
    public function addScope(Scope $scope)
    {
        $this->scope[] = $scope;

        return $this;
    }

    /**
     * Remove scope
     *
     * @param Scope $scope
     */
    public function removeScope(Scope $scope)
    {
        $this->scope->removeElement($scope);
    }

    /**
     * Get scope
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * Set user
     *
     * @param $user
     * @return AuthorizationCode
     */
    public function setUser(UserInterface $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return Usuario
     */
    public function getUser()
    {
        return $this->user;
    }
}
