<?php


namespace App\Controller;


use App\Service\AutorLeitorService\AutorLeitorData;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AutorLeitorController
{
    private $autorLeitorData;

    public function __construct(AutorLeitorData $autorLeitorData)
    {
        $this->autorLeitorData = $autorLeitorData;
    }

    /**
     * @Route("/user/create", methods={"POST"}, name="criaUsuario")
     */
    public function create(Request $request)
    {

        $data= json_decode($request->getContent());

        $this->autorLeitorData->save($data->nome,$data->email,$data->senha);

        return new JsonResponse(["msg"=>"sucesso"]);
    }

}
