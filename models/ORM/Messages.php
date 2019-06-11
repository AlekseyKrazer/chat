<?php
namespace models\ORM;

/**
 * @Entity @Table(name="messages")
 */
class Messages
{
    /** @Id @Column(type="integer") @GeneratedValue */
    protected $id;

    /** @Column(type="string") */
    protected $name;

    /** @Column(type="datetime") */
    protected $datetime;

    /** @Column(type="text") */
    protected $message;

    /** @Column(type="integer", options={"default" : 0}) */
    protected $likes;

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function setLikes($likes)
    {
        $this->likes = $likes;
    }


    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDatetime()
    {
        return $this->datetime;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getLikes()
    {
        return $this->likes;
    }
}