<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# NO CHECKED-IN PROTOBUF GENCODE
# source: opentelemetry/proto/metrics/v1/metrics.proto

namespace Opentelemetry\Proto\Metrics\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * A collection of ScopeMetrics from a Resource.
 *
 * Generated from protobuf message <code>opentelemetry.proto.metrics.v1.ResourceMetrics</code>
 */
class ResourceMetrics extends \Google\Protobuf\Internal\Message
{
    /**
     * The resource for the metrics in this message.
     * If this field is not set then no resource info is known.
     *
     * Generated from protobuf field <code>.opentelemetry.proto.resource.v1.Resource resource = 1;</code>
     */
    protected $resource = null;
    /**
     * A list of metrics that originate from a resource.
     *
     * Generated from protobuf field <code>repeated .opentelemetry.proto.metrics.v1.ScopeMetrics scope_metrics = 2;</code>
     */
    private $scope_metrics;
    /**
     * The Schema URL, if known. This is the identifier of the Schema that the resource data
     * is recorded in. Notably, the last part of the URL path is the version number of the
     * schema: http[s]://server[:port]/path/<version>. To learn more about Schema URL see
     * https://opentelemetry.io/docs/specs/otel/schemas/#schema-url
     * This schema_url applies to the data in the "resource" field. It does not apply
     * to the data in the "scope_metrics" field which have their own schema_url field.
     *
     * Generated from protobuf field <code>string schema_url = 3;</code>
     */
    protected $schema_url = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type \Opentelemetry\Proto\Resource\V1\Resource $resource
     *           The resource for the metrics in this message.
     *           If this field is not set then no resource info is known.
     *     @type array<\Opentelemetry\Proto\Metrics\V1\ScopeMetrics>|\Google\Protobuf\Internal\RepeatedField $scope_metrics
     *           A list of metrics that originate from a resource.
     *     @type string $schema_url
     *           The Schema URL, if known. This is the identifier of the Schema that the resource data
     *           is recorded in. Notably, the last part of the URL path is the version number of the
     *           schema: http[s]://server[:port]/path/<version>. To learn more about Schema URL see
     *           https://opentelemetry.io/docs/specs/otel/schemas/#schema-url
     *           This schema_url applies to the data in the "resource" field. It does not apply
     *           to the data in the "scope_metrics" field which have their own schema_url field.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Opentelemetry\Proto\Metrics\V1\Metrics::initOnce();
        parent::__construct($data);
    }

    /**
     * The resource for the metrics in this message.
     * If this field is not set then no resource info is known.
     *
     * Generated from protobuf field <code>.opentelemetry.proto.resource.v1.Resource resource = 1;</code>
     * @return \Opentelemetry\Proto\Resource\V1\Resource|null
     */
    public function getResource()
    {
        return $this->resource;
    }

    public function hasResource()
    {
        return isset($this->resource);
    }

    public function clearResource()
    {
        unset($this->resource);
    }

    /**
     * The resource for the metrics in this message.
     * If this field is not set then no resource info is known.
     *
     * Generated from protobuf field <code>.opentelemetry.proto.resource.v1.Resource resource = 1;</code>
     * @param \Opentelemetry\Proto\Resource\V1\Resource $var
     * @return $this
     */
    public function setResource($var)
    {
        GPBUtil::checkMessage($var, \Opentelemetry\Proto\Resource\V1\Resource::class);
        $this->resource = $var;

        return $this;
    }

    /**
     * A list of metrics that originate from a resource.
     *
     * Generated from protobuf field <code>repeated .opentelemetry.proto.metrics.v1.ScopeMetrics scope_metrics = 2;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getScopeMetrics()
    {
        return $this->scope_metrics;
    }

    /**
     * A list of metrics that originate from a resource.
     *
     * Generated from protobuf field <code>repeated .opentelemetry.proto.metrics.v1.ScopeMetrics scope_metrics = 2;</code>
     * @param array<\Opentelemetry\Proto\Metrics\V1\ScopeMetrics>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setScopeMetrics($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Opentelemetry\Proto\Metrics\V1\ScopeMetrics::class);
        $this->scope_metrics = $arr;

        return $this;
    }

    /**
     * The Schema URL, if known. This is the identifier of the Schema that the resource data
     * is recorded in. Notably, the last part of the URL path is the version number of the
     * schema: http[s]://server[:port]/path/<version>. To learn more about Schema URL see
     * https://opentelemetry.io/docs/specs/otel/schemas/#schema-url
     * This schema_url applies to the data in the "resource" field. It does not apply
     * to the data in the "scope_metrics" field which have their own schema_url field.
     *
     * Generated from protobuf field <code>string schema_url = 3;</code>
     * @return string
     */
    public function getSchemaUrl()
    {
        return $this->schema_url;
    }

    /**
     * The Schema URL, if known. This is the identifier of the Schema that the resource data
     * is recorded in. Notably, the last part of the URL path is the version number of the
     * schema: http[s]://server[:port]/path/<version>. To learn more about Schema URL see
     * https://opentelemetry.io/docs/specs/otel/schemas/#schema-url
     * This schema_url applies to the data in the "resource" field. It does not apply
     * to the data in the "scope_metrics" field which have their own schema_url field.
     *
     * Generated from protobuf field <code>string schema_url = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setSchemaUrl($var)
    {
        GPBUtil::checkString($var, True);
        $this->schema_url = $var;

        return $this;
    }

}

