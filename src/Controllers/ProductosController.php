<?php namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controllers\BaseController;
use Slim\Psr7\UploadedFile;

class ProductosController extends BaseController{

  //listar productos
  public function getAll(Request $request, Response $response){
    $pdo=$this->container->get('db');
    $query = $pdo->query("SELECT * FROM productos");


    // $result=array(
    //   'status'=>'success',
    //   'code'=>200,
    //   'datos'=>$consulta
    // );
 
    $response->getBody()->write(json_encode($query->fetchAll()));
    $response->withHeader('Content-type', 'application/json');
    return $response;
  }

  //Devolver un productos
  public function getById(Request $request, Response $response){
    $pdo=$this->container->get('db');
    $id = $request->getAttribute('id');   
    $query = $pdo->query("SELECT * FROM productos where id=".$id.";");
    if ($query->rowCount() != 0) {      
      $response->getBody()->write(json_encode($query->fetch()));
    }    
    $response->withHeader('Content-type', 'application/json');
    return $response;
  }

  //Eliminar un producto
  public function eliminarProducto(Request $request, Response $response){
    $pdo=$this->container->get('db');
    $id = $request->getAttribute('id');
    $result=[];
    $query = $pdo->query("DELETE FROM productos where id=".$id.";");
    if ($query) {
      $result=array(
        'status'=>'success',
        'code'=>200,
        'message'=>'El producto se ha eliminado'
      );
    }else{
      $result=array(
        'status'=>'error',
        'code'=>404,
        'message'=>'El producto NO se ha eliminado'
      );
    }
    $response->getBody()->write(json_encode($result));
    return $response;
  }

  //Devolver un productos
  public function updateById(Request $request, Response $response){
    $pdo=$this->container->get('db');
    $id = $request->getAttribute('id');
    $put = $request->getParsedBody(); //captura los datos del post
    $data = json_decode($put['json'],true);

    $query="update productos set nombre="."'{$data['nombre']}',".
    " description="."'{$data['description']}',";

    if(isset($data['imagen'])){
      $query.=" imagen="."'{$data['imagen']}',";
    }

    $query.=" precio ="."'{$data['precio']}'"." where id=".$id.";";

    $resultado = $pdo->query($query);
    $result=[];
    if ($resultado) {
      $result=array(
        'status'=>'success',
        'code'=>200,
        'message'=>'El producto se ha modificado'
      );
    }else{
      $result=array(
        'status'=>'error',
        'code'=>404,
        'message'=>'El producto NO se ha modificado'
      );
    }
    $response->getBody()->write(json_encode($result));   
    return $response;
  }

  //insertar productos
  public function insertProducto(Request $request, Response $response){
    $pdo=$this->container->get('db');
    $post = $request->getParsedBody(); //captura los datos del post
    $data = json_decode($post['json'],true);
    $result=[];
    if(!isset($data['imagen'])){
      $data['imagen']=null;
    }
    if(!isset($data['descripcion'])){
      $data['descripcion']=null;
    }

    $query="INSERT INTO productos VALUES (null,".
            "'{$data['nombre']}',".
            "'{$data['descripcion']}',".
            "'{$data['precio']}',".
            "'{$data['imagen']}'".");";
    $insert=$pdo->query($query);

    if($insert){
      $result=array(
        'status'=>'success',
        'code'=> 200,
        'message'=>'Producto creado correctamente'
      );
    }else{
      $result=array(
        'status'=>'error',
        'code'=> 404,
        'message'=>'Producto No se ha creado'
      );
    } 
    $response->getBody()->write(json_encode($result));
    $response->withHeader('Content-type', 'application/json');
    return $response;
  }

  //Subir una imagen a un producto
  public function uploadFileProducto(Request $request, Response $response){
    $result=array(
      'status'=>'error',
      'code'=> 404,
      'message'=>'Producto No se ha creado',
      'filename'=>' '
    );
    $uploadedFiles = $request->getUploadedFiles();
    $directory=$this->container->get('uploadFileProducto'); ;
   
    if($uploadedFiles){
      $imagen=$uploadedFiles['imagen'];
      $filename=$this->moveUploadedFile($directory, $imagen);
      $result=array(   
        'status'=>'success',
        'code'=> 200,
        'message'=>'Se cargo exitosamente la imagen',
        'filename'=>$filename,
        
      );
    } 
      $response->getBody()->write(json_encode($result));
      $response->withHeader('Content-type', 'application/json');
     // echo json_encode($response->getBody());
    return $response;
  }

  public function moveUploadedFile($directory, UploadedFile $uploadedFile){
    $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
    $basename = bin2hex(random_bytes(8));
    $filename = sprintf('%s.%0.8s', $basename, $extension);
    //echo '  '.$directory . DIRECTORY_SEPARATOR . $filename;
    $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);
    return $filename;
  }

}
