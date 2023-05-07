<?php declare(strict_types=1);

namespace App\Lotr\Infrastructure\Validator;

use Symfony\Component\Validator\Validator\ValidatorInterface as SymfonyValidatorInterface;

final class Validator implements ValidatorInterface
{


    public function __construct(private SymfonyValidatorInterface $validator)
    {
    }

    public function validate(mixed $value, array $groups = []): array
    {
        $groups = array_merge(['Default'], $groups);
        $errors = $this->validator->validate($value, null, $groups);

        if (0 == count($errors)) {
             return [];
        }

        $arrayErrors = [];

        foreach($errors as $error){

            /** @var \Symfony\Component\Validator\ConstraintViolation $error */
            $arrayErrors[$error->getPropertyPath()] = $error->getMessage();
        }

        return $arrayErrors;

    }
}