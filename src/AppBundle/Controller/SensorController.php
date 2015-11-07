<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class SensorController extends Controller
{
    /**
     * @Route("/sensor", name="sensor")
     */
    public function indexAction(Request $request)
    {
        $logger = $this->container->get('logger');

        $fs = new Filesystem();

        if (!$fs->exists($this->get('kernel')->getRootDir() . '/../sensor')) {
            try {
                $fs->mkdir($this->get('kernel')->getRootDir() . '/../sensor/');
            } catch (IOExceptionInterface $e) {
                echo "An error occurred while creating your directory at ".$e->getPath();
            }        
        }

        if ($request->getMethod() == 'POST') {
            $data = $request->getContent();

        /*    $encoders = array(new JsonEncoder());
            $normalizers = array(new ObjectNormalizer());
            $serializer = new Serializer($normalizers, $encoders);*/

            $xml = $this->get("request")->getContent();
            $dataObj = simplexml_load_string ($xml); 
            $payload_hex = $dataObj->payload_hex;

            $hex_array = str_split ($payload_hex,2);
            $dec_array = array_map("hexdec", $hex_array);
            $dec_array = array_diff($dec_array, array(0, '0'));

            $data = date( 'Y-m-d H:i:s')." - hex: ".$payload_hex. "\n". implode(' - ', $dec_array);
            //$sensorData = new SensorData($serializer->serialize($request->request, 'json'));
            //$logger->info($serializer->serialize($request->request, 'json'));

           // $em = $this->getDoctrine()->getManager();

            //$em->persist($sensorData);
            //$em->flush();

            $path = $this->get('kernel')->getRootDir() . '/../sensor/sensor.log';

            if (!$handle = fopen($path, "a")) {
                 print "Kann die Datei $filename nicht öffnen";
                 exit;
            }

            // Schreibe $somecontent in die geöffnete Datei.
            if (!fwrite($handle, $data."\n")) {
                print "Kann in die Datei $filename nicht schreiben";
                exit;
            }

        } else {
           /* $data = $this->getDoctrine()
                ->getRepository('AppBundle:SensorData')
                ->findAll();*/

            /*echo "<ul>";
            foreach ($data as $key => $value) {
                echo "<li>".$value->getData()."</li>";
            }
            echo "</ul>";*/

            $path = $this->get('kernel')->getRootDir() . '/../sensor/sensor.log';

            $data = [];
            $handle = fopen($path, "r");
            if ($handle) {
                while (($line = fgets($handle)) !== false) {
                    $data[] = $line;
                }

                fclose($handle);
            } else {
                // error opening the file.
            } 

            return $this->render(
                'sensor/index.html.twig', 
                array("data" => $data)
                );
        }

        return new Response();
    }
}
