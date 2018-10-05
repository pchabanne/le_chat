<?php
/**
 * @Entity @Table(name="Auteurs")
 **/
class Auteur
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    public $id;


    /** @Pseudo @Column(type="string") **/
    public $pseudo;

    /** @derniereActivite @Column(type="integer") **/
    public $derniereActivite;


    public function getId()
    {
        return $this->id;
    }

    public function getPseudo()
    {
        return $this->pseudo;
    }

    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;
    }

    public function getDerniereActivite()
    {
        return $this->derniereActivite;
    }

    public function setDerniereActivite($derniereActivite)
    {
        $this->derniereActivite = $derniereActivite;
    }

    public function getTemps()
    {
        return $this->temps;
    }
}