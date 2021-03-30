<?php 

namespace App\Traits\Api;

use Carbon\Carbon;

trait ApiResponser 
{
    /**
     * Token Generator
     *
     * @param [type] $personalAccessToken
     * @param [type] $message
     * @param integer $code
     * @return \Illuminate\Http\JsonResponse
     */
	public function token($personalAccessToken, $message = null, $data = null, $code = 200)
	{
		$tokenData = [
			'access_token' => $personalAccessToken->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse($personalAccessToken->token->expires_at)->toDateTimeString(),
            'data' => $data
		];

		return $this->success($tokenData, $message, $code);
	}


    /**
     * Success Response
     *
     * @param [type] $data
     * @param [type] $message
     * @param integer $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function success($data = null, $message = null, $code = 200)
	{
		return response()->json([
			'status' => 'Success',
			'message' => $message,
			'data' => $data
		], $code);
	}


    /**
     * Error Response
     *
     * @param [type] $message
     * @param integer $code
     * @return \Illuminate\Http\JsonResponse
     */
	public function error($message = null, $code = 422)
	{
		return response()->json([
			'status'=> 'Error',
			'message' => $message
        ], $code);
    }


    /**
     * Success Response
     *
     * @param [type] $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function noContent($message = 'No Content')
	{
		return response()->json([
            'status' => 'No Content',
            'message' => $message
		], 204);
	}
}
