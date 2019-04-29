<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Validation\ValidationException;
use League\OAuth2\Server\Exception\OAuthServerException;
use Zend\Diactoros\Stream;

class FormatApiResponse
{
    /**
     * @param $request
     * @param Closure $next
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        return $this->format($response);
    }

    protected function format($response)
    {
        if ($exception = $response->exception) {
            $content = [
                'status' => 'error',
                'code' => $exception instanceof OAuthServerException ? $exception->getHttpStatusCode() : $response->getStatusCode(),
                'message' => $exception->getMessage(),
                'data' => null,
                'errors' => $this->formatErrors($exception)
            ];
        } else {
            $content = $response->getOriginalContent();
            if ($content instanceof Stream) {
                $content = json_decode($content, true);
            }
            $content = [
                'status' => 'success',
                'code' => $response->getStatusCode(),
                'message' => 'OK',
                'data' => $content,
                'errors' => null
            ];
        }

        return response()->json($content, $response->status(),
            $response->headers->all(),
            JSON_UNESCAPED_UNICODE);
    }

    protected function formatErrors(\Exception $exception) {
        if ($exception instanceof ValidationException) {
            $errors = $exception->errors();
            return array_combine(
                array_keys($errors),
                array_map(function ($error) {
                    if (count($error) === 1) {
                        return ['message' => $error[0]];
                    }
                    return array_map(function ($message) {
                        return ['message' => $message];
                    }, $error);
                    return;
                }, $errors)
            );
        } elseif ($exception instanceof OAuthServerException) {
            return [
                'message' => $exception->getMessage(),
                'error' => $exception->getErrorType(),
                'hint' => $exception->getHint(),
            ];
        } else {
            $errors = ['message' => $exception->getMessage()];
        }
        return $errors;
    }
}
