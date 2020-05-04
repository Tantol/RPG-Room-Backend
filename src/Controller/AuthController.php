<?php

namespace App\Controller;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/", name="")
 */
class AuthController extends AbstractController
{
    protected $statusCode = 200;

    /**
     * @Route("/register", name="register") 
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->transformJsonBody($request);
        $username = $request->get('username');
        $password = $request->get('password');
        $email = $request->get('email');

        if (empty($username) || empty($password) || empty($email)) {
            return $this->respondValidationError('Invalid Username or Password or Email');
        }

        $user = new User($username);
        $user->setPassword($encoder->encodePassword($user, $password));
        $user->setEmail($email);
        $user->setUsername($username);
        $em->persist($user);
        $em->flush();

        return $this->setStatusCode(200)->respondWithSuccess(sprintf('User %s successfully created', $user->getUsername()));
    }

    /**
     * @Route("/api/login_check", name="api_login_check")
     */
    public function getTokenUser(UserInterface $user, JWTTokenManagerInterface $JWTManager): JsonResponse
    {
        return new JsonResponse(['token' => $JWTManager->create($user)]);
    }

    protected function transformJsonBody(Request $request): Request
    {
        $data = json_decode($request->getContent(), true);

        if (null === $data) {
            return $request;
        }

        $request->request->replace($data);

        return $request;
    }

    protected function respondWithSuccess(string $success, $headers = []): JsonResponse
    {
        $data = [
            'status' => $this->getStatusCode(),
            'success' => $success,
        ];

        return new JsonResponse($data, $this->getStatusCode(), $headers);
    }

    protected function getStatusCode(): int
    {
        return $this->statusCode;
    }

    protected function setStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;

        return $this;
    }
}
