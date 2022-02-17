<?php

    namespace Domain\User\Actions;

    use Auth;
    use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
    use BaconQrCode\Renderer\ImageRenderer;
    use BaconQrCode\Renderer\RendererStyle\RendererStyle;
    use BaconQrCode\Writer;
    use Domain\User\Models\UserSecurity;
    use Illuminate\Support\Facades\Crypt;
    use Illuminate\Support\Str;
    use PragmaRX\Google2FA\Exceptions\IncompatibleWithGoogleAuthenticatorException;
    use PragmaRX\Google2FA\Exceptions\InvalidAlgorithmException;
    use PragmaRX\Google2FA\Exceptions\InvalidCharactersException;
    use PragmaRX\Google2FA\Exceptions\SecretKeyTooShortException;
    use PragmaRX\Google2FA\Google2FA;
    use PragmaRX\Google2FA\Support\Constants;

    class Generate2FAKeyAction
    {
        /**
         * @throws IncompatibleWithGoogleAuthenticatorException
         * @throws InvalidAlgorithmException
         * @throws InvalidCharactersException
         * @throws SecretKeyTooShortException
         *
         * @return string
         */
        public function __invoke(): string
        {
            $user = Auth::user();
            $security = $user->security()->firstOrNew();

            if ($security instanceof UserSecurity && !$security->enabled) {
                $google2fa = new Google2FA();
                $google2fa->setAlgorithm(Constants::SHA512);

                $writer = new Writer(
                    new ImageRenderer(
                        new RendererStyle(400),
                        new ImagickImageBackEnd()
                    )
                );

                $prefix = Str::of(md5($user->id))->limit(20, '')->toString();
                $secretKey = $google2fa->generateSecretKey(32, $prefix);
                $imageData = $google2fa->getQRCodeUrl(config('app.name'), $user->email, $secretKey);

                $security->secret_key = Crypt::encryptString($secretKey);
                $security->save();

                $base64 = base64_encode($writer->writeString($imageData));

                return createBase64Image($base64);
            }

            return '';
        }
    }
