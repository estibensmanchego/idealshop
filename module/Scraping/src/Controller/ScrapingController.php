<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Scraping\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use GuzzleHttp\Client;
use Zend\Dom\Query;

class ScrapingController extends AbstractActionController
{

    public function indexAction()
    {
		return new ViewModel([
            'scraping' => '',
        ]);    	
    }

    public function wongAction()
    {
        return [
            'portal'    => 'Wong',
        ];  
    }

    public function tottusAction()
    {
        return [
            'portal'    => 'Tottus',
        ];  	
    }

    public function plazaveaAction()
    {
        return [
            'portal'    => 'plazavea',
        ];    	
    }

    public function testAction()
    {
        ### BASE ###
        /*$client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'http://www.plazavea.com.pe/abarrotes/aceite/oliva#1');
        echo $res->getBody(); */    

        ##Wong
        // create http client instance
        /*$client = new \GuzzleHttp\Client(['cookies' => true]);
        $request = new \GuzzleHttp\Psr7\Request(
            'GET', 
            'https://www.wong.com.pe/FO/supermercados/index.go?search=2&caip=1', 
            ['timeout' => 2.0, 'allow_redirects' => true]);

        $promise = $client->sendAsync($request)->then(function ($response) {
            $html = $response->getBody();

            $dom = new Query($html);
            //$results = $dom->execute('#div_categorias #navigation li a.head');
            $results = $dom->execute('#div_categorias #navigation li a.head');

            $count = count($results);
            foreach ($results as $result) {
                //$categorias[] = array("id" => $result->getAttribute('id'), "categoria" => trim($result->nodeValue));
                $categorias[] = $result->getAttribute('id');
            }
            //var_dump($categorias);

            //echo "#############################################################################################################";

            $results2 = $dom->execute('#div_categorias #navigation li a');

            foreach ($results2 as $result2) {
                //$categorias2[] = array("id" => $result2->getAttribute('id'), "categoria" => trim($result2->nodeValue));
                if (in_array($result2->getAttribute('id'), $categorias)) {
                    echo "-" . trim($result2->nodeValue) . "<br>";
                } else {
                    echo "--" . trim($result2->nodeValue) . "<br>";
                }
            }   
            //var_dump($categorias2);   

        }); 

        $promise->wait(); */

        /*$client = new \GuzzleHttp\Client(['cookies' => true]);
        $request = new \GuzzleHttp\Psr7\Request(
            'GET', 
            'https://www.wong.com.pe/FO/supermercados/index.go?search=2&caip=1', 
            ['timeout' => 2.0, 'allow_redirects' => true]);
        //$request = new \GuzzleHttp\Psr7\Request(
        //  'GET', 
        //  'https://www.wong.com.pe/FO/supermercados/productos.go?idCategoria=1&idSubCategoria=8182&fecha=25-7-2016+13%3A6%3A56%3A284&nombreCategoria=Abarrotes&nombreSubCategoria=Aceites+de+Oliva%20Name', 
        //  ['timeout' => 2.0, 'allow_redirects' => true]);

        $promise = $client->sendAsync($request)->then(function ($response) {
            $html = $response->getBody();

            var_dump($html);exit;

            $dom = new Query($html);
            //$results = $dom->execute('#div_categorias #navigation li a.head');
            $results = $dom->execute('#tabla_productos .fila_producto a.ficha_pro');

            $count = count($results);
            foreach ($results as $result) {
                $productos[] = array("id" => $result->getAttribute('ficha_pro'));
            }
            var_dump($productos);

        });

        $promise->wait(); 

        //return new ViewModel();



        ##Plazavea

        /*$client = new \GuzzleHttp\Client(['cookies' => true]);
        $request = new \GuzzleHttp\Psr7\Request(
            'GET', 
            'http://www.plazavea.com.pe', 
            ['timeout' => 2.0, 'allow_redirects' => true]);

        $promise = $client->sendAsync($request)->then(function ($response) {
            $html = $response->getBody();

            $dom = new Query($html);
            //$results = $dom->execute('#div_categorias #navigation li a.head');
            $results = $dom->execute('.u-center .nav__list .nav__item a.nav__link');

            $count = count($results);
            foreach ($results as $result) {
                //$categorias[] = array("id" => $result->getAttribute('id'), "categoria" => trim($result->nodeValue));
                $categorias[] = str_replace("/", "", $result->getAttribute('href'));
            }
            //var_dump($categorias);

            //echo "#############################################################################################################";

            $results2 = $dom->execute('.u-center .nav__list .nav__item .sub-primary a.sub-primary__link');

            foreach ($results2 as $result2) {
                //$categorias2[] = array("id" => $result2->getAttribute('id'), "categoria" => trim($result2->nodeValue));

                //$categorias2[] = array("id" => $result2->getAttribute('href'), "categoria" => trim($result2->nodeValue));

                list($vacio,$categoria,$subcategoria) = explode("/", $result2->getAttribute('href'));
                echo $categoria;
                echo " -- " . trim($result2->nodeValue) . "<br>";
                
            }
            //var_dump($categorias2);   


            $results3 = $dom->execute('.u-center .nav__list .nav__item .sub-primary a.sub-secondary__link');

            foreach ($results3 as $result3) {
                //$categorias3[] = array("id" => $result3->getAttribute('id'), "categoria" => trim($result3->nodeValue));

                //$categorias3[] = array("id" => $result3->getAttribute('href'), "categoria" => trim($result3->nodeValue));

                list($vacio,$categoria,$subcategoria,$otrasubcategoria) = explode("/", $result3->getAttribute('href'));
                echo $categoria . " -- " . $subcategoria;
                echo " --- " . trim($result3->nodeValue) . "<br>";
                
            }
            //var_dump($categorias3);   


        }); 

        $promise->wait(); */

        ##Tottus

        /*$client = new \GuzzleHttp\Client(['cookies' => true]);
        $request = new \GuzzleHttp\Psr7\Request(
            'GET', 
            'http://www.tottus.com.pe/tottus/', 
            ['debug' => true, 'timeout' => 2.0, 'allow_redirects' => true, 'User-Agent' => "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:47.0) Gecko/20100101 Firefox/47.0"]);

        $promise = $client->sendAsync($request)->then(function ($response) {
            $html = $response->getBody();

            $dom = new Query($html);
            //$results = $dom->execute('#div_categorias #navigation li a.head');
            $results = $dom->execute('.navbar ul.nav .small-nav-menu p');

            $count = count($results);
            foreach ($results as $result) {
                //$categorias[] = array("id" => $result->getAttribute('id'), "categoria" => trim($result->nodeValue));
                $categorias[] = trim($result->nodeValue);
            }
            //var_dump($categorias);

            //echo "#############################################################################################################";

            $results2 = $dom->execute('.navbar ul.nav .small-nav-menu .col-md-2-4 a');

            foreach ($results2 as $result2) {
                //$categorias2[] = array("id" => $result2->getAttribute('id'), "categoria" => trim($result2->nodeValue));

                //$categorias2[] = array("id" => $result2->getAttribute('href'), "categoria" => trim($result2->nodeValue));

                if ($result2->getAttribute('class') === "menu-header-link") {
                    echo " - " . trim($result2->nodeValue) . "<br>";
                }else {
                    echo " -- " . trim($result2->nodeValue) . "<br>";
                };
                
                
            }
            //var_dump($categorias2);   


            $results3 = $dom->execute('.u-center .nav__list .nav__item .sub-primary a.sub-secondary__link');

            foreach ($results3 as $result3) {
                //$categorias3[] = array("id" => $result3->getAttribute('id'), "categoria" => trim($result3->nodeValue));

                //$categorias3[] = array("id" => $result3->getAttribute('href'), "categoria" => trim($result3->nodeValue));

                list($vacio,$categoria,$subcategoria,$otrasubcategoria) = explode("/", $result3->getAttribute('href'));
                echo $categoria . " -- " . $subcategoria;
                echo " --- " . trim($result3->nodeValue) . "<br>";
                
            }
            //var_dump($categorias3);   


        }); 

        $promise->wait();*/ 


#       #CATEGORIAS

        #WONG
        /*$url = 'https://www.wong.com.pe/FO/supermercados/index.go';
        $query = ['search' => 1, 'caip' => 1];
        $html = $this->getBody($url, $query);

        $dom = new Query($html);
        $results = $dom->execute('#div_categorias #navigation li ul li.subcategoria a');

        $categorias = array();
        $count = count($results);
        foreach ($results as $result) {
            $categorias[] = [$result->getAttribute('id'), $result->getAttribute('onclick')];
        }
        //var_dump($categorias);

        #parametros de envio para traer productos
        #idCategoria:7048
        #idSubCategoria:8117
        #fecha:6-8-2016 12:20:11:682
        #nombreCategoria:Suplemento Carnes y Vinos de Alta Gama
        #nombreSubCategoria:Carne de Res  Nacional

        foreach ($categorias as $categoria) {   
            list($idcat, $idsubcat) = explode("_", $categoria[0]);
            list($presucatid, $nombresubcat, $catid, $nombrecat) = explode(",", $categoria[1]);
            //echo $idcat . '-' . $idsubcat . '-' . $nombrecat . '-' . $nombresubcat . '<br><br><br>';
            //$nombrecatclean = trim(trim($nombrecat, "'"));
            //$nombresubcatclean = trim(trim($nombresubcat, "'"));
            /*echo "https://www.wong.com.pe/FO/supermercados/productos.go?" 
            . "idCategoria=" . $idcat
            . "&idSubCategoria=" . $idsubcat
            . "&fecha=" . date("d-m-Y H:m:s") 
            . "&nombreCategoria=" . str_replace("'", "", trim($nombrecat))  
            . "&nombreSubCategoria=" . str_replace("'", "", trim($nombresubcat)) . "<br>"; */

        /*  $url = 'https://www.wong.com.pe/FO/supermercados/productos.go';
            $query = [
                'idCategoria' => $idcat, 
                'idSubCategoria' => $idsubcat,
                'fecha' => date("d-m-Y H:m:s"),
                'nombreCategoria' => str_replace("'", "", trim($nombrecat)),
                'nombreSubCategoria' => str_replace("'", "", trim($nombresubcat))
            ];
            $html = $this->getBody($url, $query, 'GET');
            
            $dom = new Query($html);
            var_dump($dom);
            exit;
        } */

        #Plazavea

        /*$client = new \GuzzleHttp\Client(['cookies' => true]);
        $request = new \GuzzleHttp\Psr7\Request(
            'GET', 
            'http://www.plazavea.com.pe', 
            ['timeout' => 2.0, 'allow_redirects' => true]);

        $promise = $client->sendAsync($request)->then(function ($response) {
            $html = $response->getBody();

            $dom = new Query($html);
            //$results = $dom->execute('#div_categorias #navigation li a.head');
            $results = $dom->execute('.u-center .nav__list .nav__item a.nav__link');

            /*$count = count($results);
            foreach ($results as $result) {
                //$categorias[] = array("id" => $result->getAttribute('id'), "categoria" => trim($result->nodeValue));
                $categorias[] = str_replace("/", "", $result->getAttribute('href'));
            }
            //var_dump($categorias);

            //echo "#############################################################################################################";

            $results2 = $dom->execute('.u-center .nav__list .nav__item .sub-primary a.sub-primary__link');

            foreach ($results2 as $result2) {
                //$categorias2[] = array("id" => $result2->getAttribute('id'), "categoria" => trim($result2->nodeValue));

                //$categorias2[] = array("id" => $result2->getAttribute('href'), "categoria" => trim($result2->nodeValue));

                list($vacio,$categoria,$subcategoria) = explode("/", $result2->getAttribute('href'));
                echo $categoria;
                echo " -- " . trim($result2->nodeValue) . "<br>";
                
            } */
            //var_dump($categorias2);   


            /*$results3 = $dom->execute('.u-center .nav__list .nav__item .sub-primary a.sub-secondary__link');

            foreach ($results3 as $result3) {
                //$categorias3[] = array("id" => $result3->getAttribute('id'), "categoria" => trim($result3->nodeValue));

                //$categorias3[] = array("id" => $result3->getAttribute('href'), "categoria" => trim($result3->nodeValue));

                @list($vacio,$categoria,$subcategoria,$otrasubcategoria) = explode("/", $result3->getAttribute('href'));
                //echo $categoria . " -- " . $subcategoria;
                //echo " --- " . trim($result3->nodeValue) . "<br>";
                echo "http://www.plazavea.com.pe/" . $categoria . "/" . $subcategoria . "/" . $otrasubcategoria . "<br>";
                
            }
            //var_dump($categorias3);   


        }); 

        $promise->wait(); */


        #GET PRODUCTOS DE PLAZAVEA - Funciona

        $client = new \GuzzleHttp\Client(['cookies' => true, 'headers' => ['User-Agent' => "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:47.0) Gecko/20100101 Firefox/47.0"]]);
        $options = [ 
            'timeout' => 5.0, 
            'allow_redirects' => true
        ];
        $response = $client->request('GET', 'http://www.plazavea.com.pe/abarrotes/aceite/oliva#1', $options);
        $html = $response->getBody();

        $dom_productos = new Query($html);

        $results_productos = $dom_productos->execute('div.prateleira ul li a.prateleira__image-link'); //.prateleira__content
        foreach ($results_productos as $productos) {
            $url = $productos->getAttribute('href');
            $response2 = $client->request('GET', $url, $options);
            $pro_html = $response2->getBody();
            $dom_producto = new Query($pro_html);
            $results_producto_img = $dom_producto->execute('.u-center .product-images img#image-main');
            foreach ($results_producto_img as $producto) {
                var_dump($this->getImage($producto->getAttribute('src')));
                echo $producto->getAttribute('src') . '|';
            }
            $results_producto_nombre = $dom_producto->execute('.u-center .product-name .productName');
            foreach ($results_producto_nombre as $nombre) {
                echo $nombre->nodeValue . '|';
            }
            $results_producto_precio = $dom_producto->execute('.u-center .product-information .plugin-preco');
            foreach ($results_producto_precio as $precio) {
                 echo $precio->nodeValue . '<br>';
            }
        }

        #GET PRODUCTOS DE TOTTUS - Funciona FALTA

        /*$client = new \GuzzleHttp\Client(['cookies' => true, 'headers' => ['User-Agent' => "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:47.0) Gecko/20100101 Firefox/47.0"]]);
        $options = [ 
            'timeout' => 5.0, 
            'allow_redirects' => true
        ];
        $response = $client->request('GET', 'http://www.plazavea.com.pe/abarrotes/aceite/oliva#1', $options);
        $html = $response->getBody();

        $dom_productos = new Query($html);

        $results_productos = $dom_productos->execute('div.prateleira ul li a.prateleira__image-link'); //.prateleira__content
        foreach ($results_productos as $productos) {
            $url = $productos->getAttribute('href');
            $response2 = $client->request('GET', $url, $options);
            $pro_html = $response2->getBody();
            $dom_producto = new Query($pro_html);
            $results_producto_img = $dom_producto->execute('.u-center .product-images img#image-main');
            foreach ($results_producto_img as $producto) {
                echo $producto->getAttribute('src') . '|';
            }
            $results_producto_nombre = $dom_producto->execute('.u-center .product-name .productName');
            foreach ($results_producto_nombre as $nombre) {
                echo $nombre->nodeValue . '|';
            }
            $results_producto_precio = $dom_producto->execute('.u-center .product-information .plugin-preco');
            foreach ($results_producto_precio as $precio) {
                 echo $precio->nodeValue . '<br>';
            }
        } */

        return false; 
    }

    public function getImage($url)
    {
        $name = basename($url);       
        $upload = file_put_contents(dirname(__DIR__) . "/../../../public/img/products/$name",file_get_contents($url));
        if($upload) {
            return true;
        } else {
            return false;
        }        
    }

    /*
    @params: $url string url
    @param: $query array ['foo' => 'bar']
    */
    public function getBody($url, $query='', $method = 'GET')
    {
        $tipo = ($method == 'GET') ? 'query' : 'form_params';
        $client = new \GuzzleHttp\Client(['cookies' => true, 'headers' => ['User-Agent' => "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:47.0) Gecko/20100101 Firefox/47.0"]]);
        $options = [
            'timeout' => 2.0, 
            'allow_redirects' => true, 
            'debug' => false,
            $tipo => $query
        ];
        $response = $client->request($method, $url, $options);
        return $response->getBody();
    }
}
