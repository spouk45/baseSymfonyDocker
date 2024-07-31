<?php

namespace App\Security;

use Psr\Log\LoggerInterface;
use App\Repository\EPCIRepository;
use App\Service\ApiResponseService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class ApiTokenAuthenticator extends AbstractAuthenticator
{
    private $epciRepository;
    private $logger;
    private $apiResponseService;
    
    public function __construct(EPCIRepository $epciRepository, LoggerInterface $logger,  ApiResponseService $apiResponseService)
    {
        $this->epciRepository = $epciRepository;
        $this->logger = $logger;
        $this->apiResponseService = $apiResponseService;
    }

    public function supports(Request $request): ?bool
    {
        return $request->headers->has('DOLAPIKEY');
    }

    public function authenticate(Request $request): Passport
    {
        $token = $request->headers->get('DOLAPIKEY');

        if (!$token) {
            throw new CustomUserMessageAuthenticationException('No API token provided');
        }

        $epci = $this->epciRepository->findOneBy(['token' => $token]);

        if (!$epci) {
            throw new CustomUserMessageAuthenticationException('Invalid API token');
        }

        return new SelfValidatingPassport(new UserBadge($token, function ($token) {
            return $this->epciRepository->findOneBy(['token' => $token]);
        }));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null; // On success, let the request continue
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $this->logger->error('Authentication failure: ' . $exception->getMessage(), ['exception' => $exception]);

        $message = $exception instanceof CustomUserMessageAuthenticationException
            ? $exception->getMessageKey()
            : 'Authentication request could not be processed due to a system problem.';
     
        return $this->apiResponseService->createErrorResponse(
            'Authentication failure',
            $message,
            JsonResponse::HTTP_UNAUTHORIZED
        );
    }
}
