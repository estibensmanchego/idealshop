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

use Scraping\Model\ScrapingTable;
use Scraping\Model\Scraping;

use Zend\Session\Storage\ArrayStorage;
use Zend\Session\SessionManager;

use Zend\ServiceManager\ServiceManager;

setlocale(LC_ALL, 'en_US.UTF8');

class ScrapingController extends AbstractActionController
{  
    private $table;

    public function __construct(ScrapingTable $table)
    {
        $this->table = $table;
    }

    public function indexAction()
    {
		return new ViewModel([
            'scraping' => '',
        ]);    	
    }

    public function wongAction()
    {

        //Inicilizamos ProductTable
        $product = new Scraping();
        //Tiempo
        $tiempo_inicio = $this->microtime_float();
        $url = 'https://www.wong.com.pe/FO/supermercados/index.go';
        $query = ['search' => 1, 'caip' => 1];
        $html = $this->getBody($url, $query);

        $dom = new Query($html);

        $results = $dom->execute('#div_categorias #navigation li ul li.subcategoria a');

        $categorias = array();
        $count = count($results);
        foreach ($results as $result) {
            $categorias[] = [$result->getAttribute('id'), $result->getAttribute('onclick')];
        }     

        //$cookies = $this->get_web_page($url);
        //list($ckid, $ckval) = explode("=", $cookies['cookies']);
        #opcional
        $ckval = $_GET['cookie'];

        foreach ($categorias as $categoria) {   
            list($idcat, $idsubcat) = explode("_", $categoria[0]);
            list($presucatid, $nombresubcat, $catid, $nombrecat) = explode(",", $categoria[1]);
            #IMPORT PRODUCT
            #generamos la url
            $url = 'https://www.wong.com.pe/FO/supermercados/productos.go?idCategoria='.$idcat.'&idSubCategoria='.$idsubcat.'&fecha='.date("d-m-Y H:m:s").'&nombreCategoria='.str_replace("'", "", trim($nombrecat)).'&nombreSubCategoria=' . str_replace("'", "", trim($nombresubcat));
            $headers = [
                    'Cookie' => 'JSESSIONID='.$ckval,
                    'Host' => 'www.wong.com.pe',
                    'Origin' => 'https://www.wong.com.pe',
                    'Referer' => 'https://www.wong.com.pe/FO/supermercados/index.go?search=2&caip=1',
                    'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36',
                    'X-Requested-With' => 'XMLHttpRequest',
                ];
            $client = new \GuzzleHttp\Client();
            $res = $client->request('GET', $url, [
                'timeout' => 1000, 
                'allow_redirects' => true,
                'headers' => $headers
            ]);
            $html = $res->getBody();

            $dom_productos = new Query($html);

            $data_productos = array();
            $results_productos = $dom_productos->execute('.fila_producto');
            foreach ($results_productos as $k => $productos) {
                list($fila, $id_pro) = explode("_", $productos->getAttribute('id'));
                $data_productos[$k]['id_pro'] = $id_pro;
            }
            $results_productos = $dom_productos->execute('.fila_producto #ficha_pro .tipo');
            foreach ($results_productos as $k => $productos) {
                $data_productos[$k]['tipo'] = $productos->nodeValue;
            }
            $results_productos = $dom_productos->execute('.fila_producto #ficha_pro .Marca');
            foreach ($results_productos as $k => $productos) {
                $data_productos[$k]['marca'] = $productos->nodeValue;
            }  
            $results_productos = $dom_productos->execute('.fila_producto #ficha_pro .descripcion');
            foreach ($results_productos as $k => $productos) {
                $data_productos[$k]['nombre'] =  trim($productos->nodeValue);
            }
            $results_productos = $dom_productos->execute('.fila_producto .precio');
            foreach ($results_productos as $k => $productos) {
                $data_productos[$k]['precio'] = trim($productos->nodeValue);
            }
            $results_productos_img = $dom_productos->execute('.fila_producto .body_border img');
            foreach ($results_productos_img as $k => $img) {
                $data_productos[$k]['imagen'] = "https://www.wong.com.pe".str_replace("chica", "grande", $img->getAttribute('src'));       
                //$nombre = $this->toAscii($data_productos[$k]['nombre']) . '-' . $this->toAscii($data_productos[$k]['marca']) . '-' . $data_productos[$k]['id_pro'];
                //$data_productos[$k]['estado_img'] = $this->getImage($data_productos[$k]['imagen'], $nombre, NULL, 'tottus');
            }

            var_dump($data_productos);exit;

            foreach ($data_productos as $key => $pro) {
                $product->id_brand = 1;
                $product->id_category = 2;
                $product->name = 'producto 10';
                $product->description = 'Decripcion de producto 10';
                $product->stock = '30';
                $product->status = '1';
                $product->outstanding = '0';
                $this->table->saveScraping($product);
            }

            exit;
        }
        
        //fin tiempo
        $tiempo_fin = $this->microtime_float();
        $tiempo = $tiempo_fin - $tiempo_inicio;
        echo "Tiempo empleado: " . ($tiempo_fin - $tiempo_inicio);

        //https://www.wong.com.pe/FO/supermercados/productos.go?idCategoria=3945&idSubCategoria=8251&fecha=26-09-2016 16:09:49&nombreCategoria=Encarte Cheese and Wine&nombreSubCategoria=Quesos

            /*$url = 'https://www.wong.com.pe/FO/supermercados/productos.go?idCategoria=3945&idSubCategoria=8251&fecha=26-09-2016 16:09:49&nombreCategoria=Encarte Cheese and Wine&nombreSubCategoria=Quesos';
            #get cookie
            $data = $this->get_web_page($url);
            $headers = [
                    'Cookie' => 'JSESSIONID=0000TYZRUi7PUpN-MsMFh7zgJQ3:-1;',
                    'Host' => 'www.wong.com.pe',
                    'Origin' => 'https://www.wong.com.pe',
                    'Referer' => 'https://www.wong.com.pe/FO/supermercados/index.go?search=2&caip=1',
                    'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36',
                    'X-Requested-With' => 'XMLHttpRequest',
                ];
            var_dump($headers);
            $client = new \GuzzleHttp\Client();
            $res = $client->request('GET', $url, [
                'timeout' => 10, 
                'allow_redirects' => true,
                'headers' => $headers
            ]);
            $html = $res->getBody();

            $dom_productos = new Query($html);

            $data_productos = array();
            $results_productos = $dom_productos->execute('.fila_producto');
            foreach ($results_productos as $k => $productos) {
                list($fila, $id_pro) = explode("_", $productos->getAttribute('id'));
                $data_productos[$k]['id_pro'] = $id_pro;
            }
            $results_productos = $dom_productos->execute('.fila_producto #ficha_pro .tipo');
            foreach ($results_productos as $k => $productos) {
                $data_productos[$k]['tipo'] = $productos->nodeValue;
            }
            $results_productos = $dom_productos->execute('.fila_producto #ficha_pro .Marca');
            foreach ($results_productos as $k => $productos) {
                $data_productos[$k]['marca'] = $productos->nodeValue;
            }  
            $results_productos = $dom_productos->execute('.fila_producto #ficha_pro .descripcion');
            foreach ($results_productos as $k => $productos) {
                $data_productos[$k]['nombre'] =  trim($productos->nodeValue);
            }
            $results_productos = $dom_productos->execute('.fila_producto .precio');
            foreach ($results_productos as $k => $productos) {
                $data_productos[$k]['precio'] = trim($productos->nodeValue);
            }
            $results_productos_img = $dom_productos->execute('.fila_producto .body_border img');
            foreach ($results_productos_img as $k => $img) {
                $data_productos[$k]['imagen'] = "https://www.wong.com.pe".str_replace("chica", "grande", $img->getAttribute('src'));            
                $nombre = $this->toAscii($data_productos[$k]['nombre']) . '-' . $this->toAscii($data_productos[$k]['marca']) . '-' . $data_productos[$k]['id_pro'];
                //$data_productos[$k]['estado_img'] = $this->getImage($data_productos[$k]['imagen'], $nombre, NULL, 'tottus');
            }

            var_dump($data_productos); */

        exit;
        return false;  
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

            $dom = new Query($html);
            //$results = $dom->execute('#div_categorias #navigation li a.head');
            $results = $dom->execute('#tabla_productos .fila_producto a.ficha_pro');

            $count = count($results);
            foreach ($results as $result) {
                $productos[] = array("id" => $result->getAttribute('ficha_pro'));
            }
            var_dump($productos);

        });

        $promise->wait(); */

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

        $cookies = $this->get_web_page($url);

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

        /*    $url = 'https://www.wong.com.pe/FO/supermercados/productos.go?idCategoria=1&idSubCategoria=8182&fecha=21-8-2016%2016:18:17:449&nombreCategoria=Abarrotes&nombreSubCategoria=Aceites%20de%20Oliva';
            $query = [
                'idCategoria' => $idcat, 
                'idSubCategoria' => $idsubcat,
                'fecha' => date("d-m-Y H:m:s"),
                'nombreCategoria' => str_replace("'", "", trim($nombrecat)),
                'nombreSubCategoria' => str_replace("'", "", trim($nombresubcat))
            ];
            $html = $this->getBody($url, $query, 'GET', $cookies);
            
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

        #GET PRODUCTOS DE WONG - Funciona
        #TESTTT

        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'https://www.wong.com.pe/FO/supermercados/productos.go?idCategoria=3945&idSubCategoria=8251&fecha=26-09-2016%2016:09:49&nombreCategoria=Encarte%20Cheese%20and%20Wine&nombreSubCategoria=Quesos', [
            'timeout' => 10.0, 
            'allow_redirects' => true,
            'headers' => [
                'Cookie' => 'JSESSIONID=0000TYZRUi7PUpN-MsMFh7zgJQ3:-1;',
                'Host' => 'www.wong.com.pe',
                'Origin' => 'https://www.wong.com.pe',
                'Referer' => 'https://www.wong.com.pe/FO/supermercados/index.go?search=2&caip=1',
                'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36',
                'X-Requested-With' => 'XMLHttpRequest',
            ]
        ]);
        $html = $res->getBody();

        $dom_productos = new Query($html);

        $data_productos = array();

        $results_productos = $dom_productos->execute('.fila_producto #ficha_pro .tipo');
        foreach ($results_productos as $k => $productos) {
            $data_productos[$k]['tipo'] = $productos->nodeValue;
        }
        $results_productos = $dom_productos->execute('.fila_producto #ficha_pro .Marca');
        foreach ($results_productos as $k => $productos) {
            $data_productos[$k]['marca'] = $productos->nodeValue;
        }  
        $results_productos = $dom_productos->execute('.fila_producto #ficha_pro .descripcion');
        foreach ($results_productos as $k => $productos) {
            $data_productos[$k]['nombre'] =  trim($productos->nodeValue);
        }
        $results_productos = $dom_productos->execute('.fila_producto .precio');
        foreach ($results_productos as $k => $productos) {
            $data_productos[$k]['precio'] = trim($productos->nodeValue);
        }
        $results_productos_img = $dom_productos->execute('.fila_producto .body_border img');
        foreach ($results_productos_img as $k => $img) {
            $data_productos[$k]['imagen'] = "https://www.wong.com.pe".str_replace("chica", "grande", $img->getAttribute('src'));            
            $nombre = $this->toAscii($data_productos[$k]['nombre']) . '-' . $this->toAscii($data_productos[$k]['marca']) . '-' . uniqid();
            $data_productos[$k]['estado_img'] = $this->getImage($data_productos[$k]['imagen'], $nombre, NULL, 'tottus');
        }

        var_dump($data_productos);


        #GET PRODUCTOS DE PLAZAVEA - Funciona

        /*$pag = 1;
        $limit_page = 1; 

        $client = new \GuzzleHttp\Client(['cookies' => true, 'headers' => ['User-Agent' => "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:47.0) Gecko/20100101 Firefox/47.0"]]);
        $options = [ 
            'timeout' => 10.0, 
            'allow_redirects' => true
        ];
        //Url general: http://www.plazavea.com.pe/abarrotes/aceite/oliva#1 usa un js 
        //Url real: http://www.plazavea.com.pe/buscapagina?fq=C%3a%2f431%2f433%2f599%2f&PS=12&sl=d5430711-1181-4e16-96fc-59fca4d57beb&cc=3&sm=0&PageNumber=1
        
        for ($i=$pag; $i <= $limit_page; $i++) { 
            $page_url = 'http://www.plazavea.com.pe/buscapagina?fq=C%3a%2f431%2f433%2f599%2f&PS=12&sl=d5430711-1181-4e16-96fc-59fca4d57beb&cc=3&sm=0&PageNumber='.$i;
            $response = $client->request('GET', $page_url, $options);
            $html = $response->getBody();

            $dom_productos = new Query($html);

            $error = $dom_productos->getDocument();

            if ($dom_productos != NULL) {
                $results_productos = $dom_productos->execute('div.prateleira ul li a.prateleira__image-link'); //.prateleira__content
                foreach ($results_productos as $productos) {
                    $url = $productos->getAttribute('href');
                    //para nombre de imagen
                    list($http, $vacio, $dominio, $nombre) = explode("/", $url);
                    $response2 = $client->request('GET', $url, $options);
                    $pro_html = $response2->getBody();
                    $dom_producto = new Query($pro_html);
                    /*$results_producto_img = $dom_producto->execute('.u-center .product-images img#image-main');
                    foreach ($results_producto_img as $producto) {
                        $src = str_replace("’", "", $producto->getAttribute('src'));
                        //$alt = str_replace("’", "", $producto->getAttribute('alt'));
                        //var_dump($this->getImage($src, $nombre));
                        echo $producto->getAttribute('src') . '|';
                    }
                    $results_producto_nombre = $dom_producto->execute('.u-center .product-name .productName');
                    foreach ($results_producto_nombre as $nombre) {
                        echo $nombre->nodeValue . '|';
                    }*/
                /*    $results_producto_precio = $dom_producto->execute('.u-center .product-information .plugin-preco');
                    foreach ($results_producto_precio as $precio) {
                        list($de,$precio_normal, $precio_actual) = explode("S/.", $precio->nodeValue);
                        //echo $precio->nodeValue . '<br>';
                        echo trim($precio_normal, "Ahora: ") . "|";
                        echo trim($precio_actual, "ou 1X de") . "<br>";
                    }
                }
            } else {
                break;
            }
        } */

        #GET PRODUCTOS DE TOTTUS - Funciona

        /*$client = new \GuzzleHttp\Client(['cookies' => true, 'headers' => ['User-Agent' => "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:47.0) Gecko/20100101 Firefox/47.0"]]);
        $options = [ 
            'timeout' => 9.0, 
            'allow_redirects' => true
        ];
        $response = $client->request('GET', 'http://www.tottus.com.pe/tottus/browse/Abarrotes-y-Despensa-Aceites-y-Vinagres-Aceite-de-Oliva/_/N-kptaaa?No=0&Nrpp=', $options);
        $html = $response->getBody();

        $dom_productos = new Query($html);

        $data_productos = array();

        $results_productos = $dom_productos->execute('form .item-product-caption .title h5 div');
        foreach ($results_productos as $k => $productos) {
            $data_productos[$k]['nombre'] = $productos->nodeValue;
        }
        $results_productos = $dom_productos->execute('form .item-product-caption .title h5 span');
        foreach ($results_productos as $k => $productos) {
            $data_productos[$k]['marca'] = $productos->nodeValue;
        }  
        $results_productos = $dom_productos->execute('form .item-product-caption .statement');
        foreach ($results_productos as $k => $productos) {
            $data_productos[$k]['detalle'] = $productos->nodeValue;
        }
        $results_productos = $dom_productos->execute('form .item-product-caption .offer-details');
        foreach ($results_productos as $k => $productos) {
            $data_productos[$k]['ofeta'] =  trim($productos->nodeValue);
        }
        $results_productos = $dom_productos->execute('form .item-product-caption .prices');
        foreach ($results_productos as $k => $productos) {
            $data_productos[$k]['precio'] = trim($productos->nodeValue);
        }
        $results_productos_img = $dom_productos->execute('form .modal-content img');
        foreach ($results_productos_img as $k => $img) {
            $data_productos[$k]['imagen'] = str_replace("//", "", $img->getAttribute('src'));            
            $nombre = $this->toAscii($data_productos[$k]['nombre']) . '-' . $this->toAscii($data_productos[$k]['marca']) . '-' . uniqid();
            $data_productos[$k]['estado_img'] = $this->getImage($data_productos[$k]['imagen'], $nombre, NULL, 'tottus');
        }
        var_dump($data_productos); */

        return false; 
    }

    public function getImage($src, $name, $type=NULL, $portal='plazavea')
    {
        //$name = basename($src);
        if ($portal==='tottus') {
            $data = $this->get_data($src);
            $file = $data['image'];
            list($type,$ext) = explode('/', $data['type']);
            $name = $name.'.'.$ext;
        } else {
            $img_parts = pathinfo($src);
            $name = $name.'.'.$img_parts['extension'];            
            $file = file_get_contents($src);
        }

        $upload = file_put_contents(dirname(__DIR__) . "/../../../public/img/products/$name",$file);
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
    public function getBody($url, $query='', $method = 'GET', $cookies=NULL)
    {
        $tipo = ($method == 'GET') ? 'query' : 'form_params';
        $client = new \GuzzleHttp\Client(['cookies' => true, 'headers' => ['User-Agent' => "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:47.0) Gecko/20100101 Firefox/47.0"]]);
        $options = [
            'timeout' => 10.0, 
            'allow_redirects' => true, 
            'debug' => false,
            //'cookies' => $cookies,
            $tipo => $query
        ];
        $response = $client->request($method, $url, $options);
        return $response->getBody();
    }

    function toAscii($str, $replace=array(), $delimiter='-') {
        if( !empty($replace) ) {
        $str = str_replace((array)$replace, ' ', $str);
        }

        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

        return $clean;
    }  

    function get_data($url) {
        $ch = curl_init();
        $timeout = 10;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data['image'] = curl_exec($ch);
        $data['type'] = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        curl_close($ch);
        return $data;
    }

    function get_web_page( $url, $cookiesIn = '' ){
        $options = array(
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => true,     //return headers in addition to content
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
            CURLINFO_HEADER_OUT    => true,
            CURLOPT_SSL_VERIFYPEER => false,     // Disabled SSL Cert checks
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_COOKIE         => $cookiesIn
        );

        $ch      = curl_init( $url );
        curl_setopt_array( $ch, $options );
        $rough_content = curl_exec( $ch );
        $err     = curl_errno( $ch );
        $errmsg  = curl_error( $ch );
        $header  = curl_getinfo( $ch );
        curl_close( $ch );

        $header_content = substr($rough_content, 0, $header['header_size']);
        $body_content = trim(str_replace($header_content, '', $rough_content));
        $pattern = "#Set-Cookie:\\s+(?<cookie>[^=]+=[^;]+)#m"; 
        preg_match_all($pattern, $header_content, $matches); 
        $cookiesOut = implode("; ", $matches['cookie']);

        //$header['errno']   = $err;
        //$header['errmsg']  = $errmsg;
        //$header['headers']  = $header_content;
        //$header['content'] = $body_content;
        $header['cookies'] = $cookiesOut;
        return $header;
    }    

    function microtime_float()
    {
        list($useg, $seg) = explode(" ", microtime());
        return ((float)$useg + (float)$seg);
    }    

}
