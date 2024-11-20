<?php

/**
 * Kumpulan fungsi untuk API php native
 * 
 * @author Habib Husain Nurrohim
 * @since 2024-10-30
 */


/**
 * Fungsi untuk generate respon API
 * 
 * @param array $data
 * @param int $code
 * @return json
 */


function response($data, $code)
{
    http_response_code($code);
    header('Content-Type: application/json');
    return json_encode($data);
}

function api_get_kajian()
{
    autorized();
    if(isset($_GET['id']) && !empety($_GET['id']))
    {
        $id_kajian = $_GET['id_kajian'];
        $get_data_kajian = ambil_kajian($id_kajian);

        if($get_data_kajian == NULL)
        {
            $respon = array(
                'status' => false,
                'message' => 'Data tidak di temukan',
                'data' => $get_data_kajian
            );
            echo response($respon, 500);
            die;
        }
        else
        {
            $respon = array(
                'status' => true,
                'message' => 'Sukses',
                'data' => $get_data_kajian
            );
            echo response($respon, 200);
            die;
        }
       
        }
        else
        {
            $respon = array(
                'status' => true,
                'message' => 'Sukses',
                'data' => tampil_kajian()
            );
            echo response($respon, 200);
            die;
        }
    }

    function api_post_kajian()
    {
        autorized();

        if($_POST[''])
    }

    function autorized()
    {
        $headers = getallheaders();
        if(!isset($headers['Authorization']))
        {
            $respon = array(
                'status' => false,
                'message' => 'Unauthorized',
                'data' => array()
            );
            echo response($respon, 401);
            die;
        }
        $token = explode(' ', $headers['Authorization']);
        $access_token = $token[1];

         // jwt decode
         try
         {
             $jwt_decode = JWT::decode($access_token, new Key(JWT_KEY,'HS256'));
 
             return $jwt_decode->id;
             exit();
         }
         catch(Exception $e)
         {
             $respon = array(
                 'status' => false,
                 'message' => 'Unauthorized',
                 'data' => array()
             );
     
             echo response($respon, 401);
             die;
         }
    }
