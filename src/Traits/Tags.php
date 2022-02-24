<?php

namespace BluefynInternational\ShipEngine\Traits;

use BluefynInternational\ShipEngine\DTO\Tag;
use BluefynInternational\ShipEngine\ShipEngineClient;
use BluefynInternational\ShipEngine\ShipEngineConfig;
use GuzzleHttp\Exception\GuzzleException;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

trait Tags
{
    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/list_tags
     *
     * @return array ['tags' => Tag[]]
     *
     * @throws GuzzleException|UnknownProperties
     */
    public function getTags(
        array|ShipEngineConfig $config = null,
    ) : array {
        return $this->retrieveList(
            'tags',
            [],
            $config,
            'tags',
            Tag::class,
        );
    }

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/create_tag
     *
     * @throws GuzzleException|UnknownProperties
     */
    public function createTag(
        string $tag_name,
        array|ShipEngineConfig $config = null,
    ) : array|Tag {
        $config = $this->config->merge($config);
        $response = ShipEngineClient::post(
            "tags/$tag_name",
            $config,
        );

        if ($config->asObject) {
            return new Tag($response);
        }

        return $response;
    }

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/delete_tag
     *
     * @throws GuzzleException
     */
    public function deleteTag(
        string $tag_name,
        array|ShipEngineConfig $config = null,
    ) : array {
        return ShipEngineClient::delete(
            "tags/$tag_name",
            $this->config->merge($config),
        );
    }

    /**
     * @see https://shipengine.github.io/shipengine-openapi/#operation/rename_tag
     *
     * @throws GuzzleException|UnknownProperties
     */
    public function renameTag(
        string $tag_name,
        string $new_tag_name,
        array|ShipEngineConfig $config = null,
    ) : array {
        return ShipEngineClient::put(
            "tags/$tag_name/$new_tag_name",
            $this->config->merge($config),
        );
    }
}
