<?php
/**
 * @Entity
 * @Table(name="Messages")
 **/

class Message
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;


    /** @Auteur @Column(type="string", nullable=true) **/
    protected $expediteur;

    /** @Message @Column(type="text") **/
    protected $text;

    /** @Temps @Column(type="integer", nullable=true) **/
    protected $date;


    public function getId()
    {
        return $this->id;
    }

    public function getExpediteur()
    {
        return $this->expediteur;
    }

    public function setExpediteur($expediteur)
    {
        $this->expediteur = $expediteur;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setText($text)
    {
        $this->text = $text;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }
}