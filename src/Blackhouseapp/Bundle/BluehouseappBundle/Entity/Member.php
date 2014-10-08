<?php

namespace Blackhouseapp\Bundle\BluehouseappBundle\Entity;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity()
 * @ORM\Table(name="member")
 * @UniqueEntity(
 *     fields={"username", "email"},
 *     message="用户名和电子邮箱不能重复"
 * )
 */
class Member extends BaseUser
{

    const ROLE_ADMIN='ROLE_ADMIN';
    const ROLE_USER='ROLE_USER';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        $this->created = new \DateTime();
        $this->modified = $this->created;
        $this->addRole(self::ROLE_USER);
    }

    /**
     * @Assert\NotBlank(message="用户名不可为空")
     * @Assert\Length(
     *     min="4",
     *     max="36",
     *     minMessage="用户名不能少于4个字符",
     *     maxMessage="用户名不能多于36个字符"
     * )
     * @Assert\Regex(
     *    pattern="/^[A-z0-9]*$/i",
     *    message="用户名只能使用英文字母和数字"
     * )
     */
    protected $username;


    /**
     * @Assert\Email(
     *    checkMX=true,
     *    message="请使用合法的电子信箱"
     * )
     */
    protected $email;

    /**
     *
     * @ORM\Column(name="nickname",type="string",length=255,nullable=true)
     * @Assert\Length(
     *     min="2",
     *     max="36",
     *     minMessage="昵称不能少于2个字符",
     *     maxMessage="昵称不能多于36个字符"
     * )
     */
    protected $nickname;

    /**
     * @ORM\Column(name="website", type="string",length=500, nullable=true)
     * @Assert\Url(message="请使用合法的URL地址")
     */
    protected $website;

    /**
     * @ORM\Column(name="description", type="text", nullable=true)
     * @Assert\Length(
     *     max="400",
     *     maxMessage="个人介绍不能超过400个字"
     * )
     */
    protected $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modified", type="datetime")
     */
    private $modified;

    /**
     * @param \DateTime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \DateTime $modified
     */
    public function setModified($modified)
    {
        $this->modified = $modified;
    }

    /**
     * @return \DateTime
     */
    public function getModified()
    {
        return $this->modified;
    }

    /**
     * @param mixed $nickname
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
    }

    /**
     * @return mixed
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $website
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    }

    /**
     * @return mixed
     */
    public function getWebsite()
    {
        return $this->website;
    }




}
