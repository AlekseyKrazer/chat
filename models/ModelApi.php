<?php
/**
 * Created by PhpStorm.
 * User: crazer
 * Date: 07.06.2019
 * Time: 19:40
 */

namespace Model;

use core\Model;
use models\ORM\Messages;
use Symfony\Component\Console\Input\StringInput;

/**
 * Class ModelApi
 * @package Model
 */
class ModelApi extends Model
{
    /**
     * ModelApi constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->messageRep = $this->doctrine->getRepository(Messages::class);
    }

    /**
     * @return string|void
     */
    public function getData()
    {
        $messages = $this->messageRep->findAll();

        $array = [];
        foreach ($messages as $k => $message) {
            $array[$k]['id'] = $message->getId();
            $array[$k]['name'] = $message->getName();
            $array[$k]['datetime'] = $message->getDatetime()->format("Y-m-d H:i:s");
            $array[$k]['message'] = $message->getMessage();
            $array[$k]['likes'] = $message->getLikes();
        }
        $json = json_encode($array);
        return $json;
    }

    /**
     * @param $data
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function insert($data)
    {
        $username = $data['username'];
        $message  = $data['message'];
        $message =$this->formatMessage($message);
        $datetime = new \DateTime();

        $messages = new Messages();
        $messages->setName($username);
        $messages->setMessage($message);
        $messages->setDatetime($datetime);
        $messages->setLikes(0);

        $this->doctrine->persist($messages);
        $this->doctrine->flush();
    }

    /**
     * @param $data
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete($data)
    {
        $id = intval($data['id']);
        $message = $this->messageRep->find($id);
        if (isset($message)) {
            $username = $message->getName();

            if ($username == $_COOKIE['username']) {
                $this->doctrine->remove($message);
                $this->doctrine->flush();
            }
        }
    }

    /**
     * @param $data
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function like($data)
    {
        $id = intval($data['id']);
        $message = $this->messageRep->find($id);
        $message->setLikes($message->getLikes()+1);
        $this->doctrine->persist($message);
        $this->doctrine->flush();
    }

    /**
     * @param $file
     *
     * @return string
     */
    public function addFile($file)
    {
            $target_dir = "files/";
            $fullfilename = $file['name'];
            $path = pathinfo($fullfilename);
            $filename = $path['filename'];
            $ext = $path['extension'];
            $temp_name = $file['tmp_name'];
            $path_filename_ext = $target_dir.$filename.".".$ext;
        if (file_exists($path_filename_ext)) {
                $result = "Такой файл уже существует";
        } else {
            move_uploaded_file($temp_name, $path_filename_ext);
                $result = "Файл успешно залит";
        }
        return $result;
    }

    /**
     * @param $message
     *
     * @return mixed|string
     */
    private function formatMessage($message)
    {
        $message = nl2br($message);
        $message = $this->getImg($message);
        $message = $this->getUrl($message);
        $message = $this->getYoutube($message);
        return $message;
    }

    /**
     * @param $message
     *
     * @return mixed
     */
    private function getImg($message)
    {
        $pattern='/\[img\](.*?)\[\/img\]/is';
        preg_match_all($pattern, $message, $matches);
        foreach ($matches[1] as $k) {
            $message = str_replace("[img]".$k."[/img]", "<img src='files/".$k."'>", $message);
        }
        return $message;
    }

    /**
     * @param $message
     *
     * @return mixed
     */
    private function getUrl($message)
    {
        $pattern='/\[url\](.*?)\[\/url\]/is';
        preg_match_all($pattern, $message, $matches);
        foreach ($matches[1] as $k) {
            if (substr_count($k, "http")>0) {
                $message = str_replace(
                    "[url]" . $k . "[/url]",
                    "<a target=\"_blank\" href=\"" . $k . "\">" . $k . "</a>",
                    $message
                );
            } else {
                $message = str_replace(
                    "[url]" . $k . "[/url]",
                    "<a target=\"_blank\" href=\"http://" . $k . "\">" . $k . "</a>",
                    $message
                );
            }
        }
        return $message;
    }

    /**
     * @param $message
     *
     * @return mixed
     */
    private function getYoutube($message)
    {
        $pattern='/\[youtube\].*?v=(.*?)\[\/youtube\]/is';
        preg_match_all($pattern, $message, $matches);
        foreach ($matches[1] as $k) {
            $message = str_replace("[youtube]https://www.youtube.com/watch?v=".$k."[/youtube]", "<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/".$k."\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>", $message);
        }
        return $message;
    }
}
