<?php

namespace App\Serializer\Normalizer;

use App\Entity\KeywordGroup;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;

class KeywordGroupCsvNormalizer implements ContextAwareNormalizerInterface, CacheableSupportsMethodInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    private const ALREADY_CALLED = 'KEYWORDGROUP_NORMALIZER_AKREADY_CALLED';

    /**
     * @param KeywordGroup $object
     * @param [type] $format
     * @param array $context
     * @return array
     */
    public function normalize($object, $format = null, array $context = []): array
    {
        //to avoid recursion
        $context[self::ALREADY_CALLED] = true;
        $data = $this->normalizer->normalize($object, $format, $context);

        //return unmodified data if format is not csv
        if ($format !== 'csv') {
            return $data;
        }

        $data = [];

        //one row per keyword
        foreach ($object->getKeywords() as $keyword) {
            $data[] = [
                'domain' => $keyword->getDomain()->getName(),
                'keyword_group' => $object->getName(),
                'keyword' => $keyword->getName()
            ];
        }

        return $data;
    }

    public function supportsNormalization($data, $format = null, array $context = []): bool
    {
        //abort if context self::ALREADY_CALLED is set to avoid recursion
        if (isset($context[self::ALREADY_CALLED])) {
            return false;
        }
        return $data instanceof KeywordGroup;
    }

    public function hasCacheableSupportsMethod(): bool
    {
        return false;
    }
}
