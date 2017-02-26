<?php
namespace AppBundle\Modals;
/**
 * Created by PhpStorm.
 * User: dimka
 * Date: 26.02.17
 * Time: 14:24
 */
class Login
{
    private $name;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPasswod()
    {
        return $this->passwod;
    }

    /**
     * @param mixed $passwod
     */
    public function setPasswod($passwod)
    {
        $this->passwod = $passwod;
    }
    private $passwod;

}