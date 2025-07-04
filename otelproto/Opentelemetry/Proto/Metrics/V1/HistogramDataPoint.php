<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# NO CHECKED-IN PROTOBUF GENCODE
# source: opentelemetry/proto/metrics/v1/metrics.proto

namespace Opentelemetry\Proto\Metrics\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * HistogramDataPoint is a single data point in a timeseries that describes the
 * time-varying values of a Histogram. A Histogram contains summary statistics
 * for a population of values, it may optionally contain the distribution of
 * those values across a set of buckets.
 * If the histogram contains the distribution of values, then both
 * "explicit_bounds" and "bucket counts" fields must be defined.
 * If the histogram does not contain the distribution of values, then both
 * "explicit_bounds" and "bucket_counts" must be omitted and only "count" and
 * "sum" are known.
 *
 * Generated from protobuf message <code>opentelemetry.proto.metrics.v1.HistogramDataPoint</code>
 */
class HistogramDataPoint extends \Google\Protobuf\Internal\Message
{
    /**
     * The set of key/value pairs that uniquely identify the timeseries from
     * where this point belongs. The list may be empty (may contain 0 elements).
     * Attribute keys MUST be unique (it is not allowed to have more than one
     * attribute with the same key).
     *
     * Generated from protobuf field <code>repeated .opentelemetry.proto.common.v1.KeyValue attributes = 9;</code>
     */
    private $attributes;
    /**
     * StartTimeUnixNano is optional but strongly encouraged, see the
     * the detailed comments above Metric.
     * Value is UNIX Epoch time in nanoseconds since 00:00:00 UTC on 1 January
     * 1970.
     *
     * Generated from protobuf field <code>fixed64 start_time_unix_nano = 2;</code>
     */
    protected $start_time_unix_nano = 0;
    /**
     * TimeUnixNano is required, see the detailed comments above Metric.
     * Value is UNIX Epoch time in nanoseconds since 00:00:00 UTC on 1 January
     * 1970.
     *
     * Generated from protobuf field <code>fixed64 time_unix_nano = 3;</code>
     */
    protected $time_unix_nano = 0;
    /**
     * count is the number of values in the population. Must be non-negative. This
     * value must be equal to the sum of the "count" fields in buckets if a
     * histogram is provided.
     *
     * Generated from protobuf field <code>fixed64 count = 4;</code>
     */
    protected $count = 0;
    /**
     * sum of the values in the population. If count is zero then this field
     * must be zero.
     * Note: Sum should only be filled out when measuring non-negative discrete
     * events, and is assumed to be monotonic over the values of these events.
     * Negative events *can* be recorded, but sum should not be filled out when
     * doing so.  This is specifically to enforce compatibility w/ OpenMetrics,
     * see: https://github.com/prometheus/OpenMetrics/blob/v1.0.0/specification/OpenMetrics.md#histogram
     *
     * Generated from protobuf field <code>optional double sum = 5;</code>
     */
    protected $sum = null;
    /**
     * bucket_counts is an optional field contains the count values of histogram
     * for each bucket.
     * The sum of the bucket_counts must equal the value in the count field.
     * The number of elements in bucket_counts array must be by one greater than
     * the number of elements in explicit_bounds array. The exception to this rule
     * is when the length of bucket_counts is 0, then the length of explicit_bounds
     * must also be 0.
     *
     * Generated from protobuf field <code>repeated fixed64 bucket_counts = 6;</code>
     */
    private $bucket_counts;
    /**
     * explicit_bounds specifies buckets with explicitly defined bounds for values.
     * The boundaries for bucket at index i are:
     * (-infinity, explicit_bounds[i]] for i == 0
     * (explicit_bounds[i-1], explicit_bounds[i]] for 0 < i < size(explicit_bounds)
     * (explicit_bounds[i-1], +infinity) for i == size(explicit_bounds)
     * The values in the explicit_bounds array must be strictly increasing.
     * Histogram buckets are inclusive of their upper boundary, except the last
     * bucket where the boundary is at infinity. This format is intentionally
     * compatible with the OpenMetrics histogram definition.
     * If bucket_counts length is 0 then explicit_bounds length must also be 0,
     * otherwise the data point is invalid.
     *
     * Generated from protobuf field <code>repeated double explicit_bounds = 7;</code>
     */
    private $explicit_bounds;
    /**
     * (Optional) List of exemplars collected from
     * measurements that were used to form the data point
     *
     * Generated from protobuf field <code>repeated .opentelemetry.proto.metrics.v1.Exemplar exemplars = 8;</code>
     */
    private $exemplars;
    /**
     * Flags that apply to this specific data point.  See DataPointFlags
     * for the available flags and their meaning.
     *
     * Generated from protobuf field <code>uint32 flags = 10;</code>
     */
    protected $flags = 0;
    /**
     * min is the minimum value over (start_time, end_time].
     *
     * Generated from protobuf field <code>optional double min = 11;</code>
     */
    protected $min = null;
    /**
     * max is the maximum value over (start_time, end_time].
     *
     * Generated from protobuf field <code>optional double max = 12;</code>
     */
    protected $max = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type array<\Opentelemetry\Proto\Common\V1\KeyValue>|\Google\Protobuf\Internal\RepeatedField $attributes
     *           The set of key/value pairs that uniquely identify the timeseries from
     *           where this point belongs. The list may be empty (may contain 0 elements).
     *           Attribute keys MUST be unique (it is not allowed to have more than one
     *           attribute with the same key).
     *     @type int|string $start_time_unix_nano
     *           StartTimeUnixNano is optional but strongly encouraged, see the
     *           the detailed comments above Metric.
     *           Value is UNIX Epoch time in nanoseconds since 00:00:00 UTC on 1 January
     *           1970.
     *     @type int|string $time_unix_nano
     *           TimeUnixNano is required, see the detailed comments above Metric.
     *           Value is UNIX Epoch time in nanoseconds since 00:00:00 UTC on 1 January
     *           1970.
     *     @type int|string $count
     *           count is the number of values in the population. Must be non-negative. This
     *           value must be equal to the sum of the "count" fields in buckets if a
     *           histogram is provided.
     *     @type float $sum
     *           sum of the values in the population. If count is zero then this field
     *           must be zero.
     *           Note: Sum should only be filled out when measuring non-negative discrete
     *           events, and is assumed to be monotonic over the values of these events.
     *           Negative events *can* be recorded, but sum should not be filled out when
     *           doing so.  This is specifically to enforce compatibility w/ OpenMetrics,
     *           see: https://github.com/prometheus/OpenMetrics/blob/v1.0.0/specification/OpenMetrics.md#histogram
     *     @type array<int>|array<string>|\Google\Protobuf\Internal\RepeatedField $bucket_counts
     *           bucket_counts is an optional field contains the count values of histogram
     *           for each bucket.
     *           The sum of the bucket_counts must equal the value in the count field.
     *           The number of elements in bucket_counts array must be by one greater than
     *           the number of elements in explicit_bounds array. The exception to this rule
     *           is when the length of bucket_counts is 0, then the length of explicit_bounds
     *           must also be 0.
     *     @type array<float>|\Google\Protobuf\Internal\RepeatedField $explicit_bounds
     *           explicit_bounds specifies buckets with explicitly defined bounds for values.
     *           The boundaries for bucket at index i are:
     *           (-infinity, explicit_bounds[i]] for i == 0
     *           (explicit_bounds[i-1], explicit_bounds[i]] for 0 < i < size(explicit_bounds)
     *           (explicit_bounds[i-1], +infinity) for i == size(explicit_bounds)
     *           The values in the explicit_bounds array must be strictly increasing.
     *           Histogram buckets are inclusive of their upper boundary, except the last
     *           bucket where the boundary is at infinity. This format is intentionally
     *           compatible with the OpenMetrics histogram definition.
     *           If bucket_counts length is 0 then explicit_bounds length must also be 0,
     *           otherwise the data point is invalid.
     *     @type array<\Opentelemetry\Proto\Metrics\V1\Exemplar>|\Google\Protobuf\Internal\RepeatedField $exemplars
     *           (Optional) List of exemplars collected from
     *           measurements that were used to form the data point
     *     @type int $flags
     *           Flags that apply to this specific data point.  See DataPointFlags
     *           for the available flags and their meaning.
     *     @type float $min
     *           min is the minimum value over (start_time, end_time].
     *     @type float $max
     *           max is the maximum value over (start_time, end_time].
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Opentelemetry\Proto\Metrics\V1\Metrics::initOnce();
        parent::__construct($data);
    }

    /**
     * The set of key/value pairs that uniquely identify the timeseries from
     * where this point belongs. The list may be empty (may contain 0 elements).
     * Attribute keys MUST be unique (it is not allowed to have more than one
     * attribute with the same key).
     *
     * Generated from protobuf field <code>repeated .opentelemetry.proto.common.v1.KeyValue attributes = 9;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * The set of key/value pairs that uniquely identify the timeseries from
     * where this point belongs. The list may be empty (may contain 0 elements).
     * Attribute keys MUST be unique (it is not allowed to have more than one
     * attribute with the same key).
     *
     * Generated from protobuf field <code>repeated .opentelemetry.proto.common.v1.KeyValue attributes = 9;</code>
     * @param array<\Opentelemetry\Proto\Common\V1\KeyValue>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setAttributes($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Opentelemetry\Proto\Common\V1\KeyValue::class);
        $this->attributes = $arr;

        return $this;
    }

    /**
     * StartTimeUnixNano is optional but strongly encouraged, see the
     * the detailed comments above Metric.
     * Value is UNIX Epoch time in nanoseconds since 00:00:00 UTC on 1 January
     * 1970.
     *
     * Generated from protobuf field <code>fixed64 start_time_unix_nano = 2;</code>
     * @return int|string
     */
    public function getStartTimeUnixNano()
    {
        return $this->start_time_unix_nano;
    }

    /**
     * StartTimeUnixNano is optional but strongly encouraged, see the
     * the detailed comments above Metric.
     * Value is UNIX Epoch time in nanoseconds since 00:00:00 UTC on 1 January
     * 1970.
     *
     * Generated from protobuf field <code>fixed64 start_time_unix_nano = 2;</code>
     * @param int|string $var
     * @return $this
     */
    public function setStartTimeUnixNano($var)
    {
        GPBUtil::checkUint64($var);
        $this->start_time_unix_nano = $var;

        return $this;
    }

    /**
     * TimeUnixNano is required, see the detailed comments above Metric.
     * Value is UNIX Epoch time in nanoseconds since 00:00:00 UTC on 1 January
     * 1970.
     *
     * Generated from protobuf field <code>fixed64 time_unix_nano = 3;</code>
     * @return int|string
     */
    public function getTimeUnixNano()
    {
        return $this->time_unix_nano;
    }

    /**
     * TimeUnixNano is required, see the detailed comments above Metric.
     * Value is UNIX Epoch time in nanoseconds since 00:00:00 UTC on 1 January
     * 1970.
     *
     * Generated from protobuf field <code>fixed64 time_unix_nano = 3;</code>
     * @param int|string $var
     * @return $this
     */
    public function setTimeUnixNano($var)
    {
        GPBUtil::checkUint64($var);
        $this->time_unix_nano = $var;

        return $this;
    }

    /**
     * count is the number of values in the population. Must be non-negative. This
     * value must be equal to the sum of the "count" fields in buckets if a
     * histogram is provided.
     *
     * Generated from protobuf field <code>fixed64 count = 4;</code>
     * @return int|string
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * count is the number of values in the population. Must be non-negative. This
     * value must be equal to the sum of the "count" fields in buckets if a
     * histogram is provided.
     *
     * Generated from protobuf field <code>fixed64 count = 4;</code>
     * @param int|string $var
     * @return $this
     */
    public function setCount($var)
    {
        GPBUtil::checkUint64($var);
        $this->count = $var;

        return $this;
    }

    /**
     * sum of the values in the population. If count is zero then this field
     * must be zero.
     * Note: Sum should only be filled out when measuring non-negative discrete
     * events, and is assumed to be monotonic over the values of these events.
     * Negative events *can* be recorded, but sum should not be filled out when
     * doing so.  This is specifically to enforce compatibility w/ OpenMetrics,
     * see: https://github.com/prometheus/OpenMetrics/blob/v1.0.0/specification/OpenMetrics.md#histogram
     *
     * Generated from protobuf field <code>optional double sum = 5;</code>
     * @return float
     */
    public function getSum()
    {
        return isset($this->sum) ? $this->sum : 0.0;
    }

    public function hasSum()
    {
        return isset($this->sum);
    }

    public function clearSum()
    {
        unset($this->sum);
    }

    /**
     * sum of the values in the population. If count is zero then this field
     * must be zero.
     * Note: Sum should only be filled out when measuring non-negative discrete
     * events, and is assumed to be monotonic over the values of these events.
     * Negative events *can* be recorded, but sum should not be filled out when
     * doing so.  This is specifically to enforce compatibility w/ OpenMetrics,
     * see: https://github.com/prometheus/OpenMetrics/blob/v1.0.0/specification/OpenMetrics.md#histogram
     *
     * Generated from protobuf field <code>optional double sum = 5;</code>
     * @param float $var
     * @return $this
     */
    public function setSum($var)
    {
        GPBUtil::checkDouble($var);
        $this->sum = $var;

        return $this;
    }

    /**
     * bucket_counts is an optional field contains the count values of histogram
     * for each bucket.
     * The sum of the bucket_counts must equal the value in the count field.
     * The number of elements in bucket_counts array must be by one greater than
     * the number of elements in explicit_bounds array. The exception to this rule
     * is when the length of bucket_counts is 0, then the length of explicit_bounds
     * must also be 0.
     *
     * Generated from protobuf field <code>repeated fixed64 bucket_counts = 6;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getBucketCounts()
    {
        return $this->bucket_counts;
    }

    /**
     * bucket_counts is an optional field contains the count values of histogram
     * for each bucket.
     * The sum of the bucket_counts must equal the value in the count field.
     * The number of elements in bucket_counts array must be by one greater than
     * the number of elements in explicit_bounds array. The exception to this rule
     * is when the length of bucket_counts is 0, then the length of explicit_bounds
     * must also be 0.
     *
     * Generated from protobuf field <code>repeated fixed64 bucket_counts = 6;</code>
     * @param array<int>|array<string>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setBucketCounts($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::FIXED64);
        $this->bucket_counts = $arr;

        return $this;
    }

    /**
     * explicit_bounds specifies buckets with explicitly defined bounds for values.
     * The boundaries for bucket at index i are:
     * (-infinity, explicit_bounds[i]] for i == 0
     * (explicit_bounds[i-1], explicit_bounds[i]] for 0 < i < size(explicit_bounds)
     * (explicit_bounds[i-1], +infinity) for i == size(explicit_bounds)
     * The values in the explicit_bounds array must be strictly increasing.
     * Histogram buckets are inclusive of their upper boundary, except the last
     * bucket where the boundary is at infinity. This format is intentionally
     * compatible with the OpenMetrics histogram definition.
     * If bucket_counts length is 0 then explicit_bounds length must also be 0,
     * otherwise the data point is invalid.
     *
     * Generated from protobuf field <code>repeated double explicit_bounds = 7;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getExplicitBounds()
    {
        return $this->explicit_bounds;
    }

    /**
     * explicit_bounds specifies buckets with explicitly defined bounds for values.
     * The boundaries for bucket at index i are:
     * (-infinity, explicit_bounds[i]] for i == 0
     * (explicit_bounds[i-1], explicit_bounds[i]] for 0 < i < size(explicit_bounds)
     * (explicit_bounds[i-1], +infinity) for i == size(explicit_bounds)
     * The values in the explicit_bounds array must be strictly increasing.
     * Histogram buckets are inclusive of their upper boundary, except the last
     * bucket where the boundary is at infinity. This format is intentionally
     * compatible with the OpenMetrics histogram definition.
     * If bucket_counts length is 0 then explicit_bounds length must also be 0,
     * otherwise the data point is invalid.
     *
     * Generated from protobuf field <code>repeated double explicit_bounds = 7;</code>
     * @param array<float>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setExplicitBounds($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::DOUBLE);
        $this->explicit_bounds = $arr;

        return $this;
    }

    /**
     * (Optional) List of exemplars collected from
     * measurements that were used to form the data point
     *
     * Generated from protobuf field <code>repeated .opentelemetry.proto.metrics.v1.Exemplar exemplars = 8;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getExemplars()
    {
        return $this->exemplars;
    }

    /**
     * (Optional) List of exemplars collected from
     * measurements that were used to form the data point
     *
     * Generated from protobuf field <code>repeated .opentelemetry.proto.metrics.v1.Exemplar exemplars = 8;</code>
     * @param array<\Opentelemetry\Proto\Metrics\V1\Exemplar>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setExemplars($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Opentelemetry\Proto\Metrics\V1\Exemplar::class);
        $this->exemplars = $arr;

        return $this;
    }

    /**
     * Flags that apply to this specific data point.  See DataPointFlags
     * for the available flags and their meaning.
     *
     * Generated from protobuf field <code>uint32 flags = 10;</code>
     * @return int
     */
    public function getFlags()
    {
        return $this->flags;
    }

    /**
     * Flags that apply to this specific data point.  See DataPointFlags
     * for the available flags and their meaning.
     *
     * Generated from protobuf field <code>uint32 flags = 10;</code>
     * @param int $var
     * @return $this
     */
    public function setFlags($var)
    {
        GPBUtil::checkUint32($var);
        $this->flags = $var;

        return $this;
    }

    /**
     * min is the minimum value over (start_time, end_time].
     *
     * Generated from protobuf field <code>optional double min = 11;</code>
     * @return float
     */
    public function getMin()
    {
        return isset($this->min) ? $this->min : 0.0;
    }

    public function hasMin()
    {
        return isset($this->min);
    }

    public function clearMin()
    {
        unset($this->min);
    }

    /**
     * min is the minimum value over (start_time, end_time].
     *
     * Generated from protobuf field <code>optional double min = 11;</code>
     * @param float $var
     * @return $this
     */
    public function setMin($var)
    {
        GPBUtil::checkDouble($var);
        $this->min = $var;

        return $this;
    }

    /**
     * max is the maximum value over (start_time, end_time].
     *
     * Generated from protobuf field <code>optional double max = 12;</code>
     * @return float
     */
    public function getMax()
    {
        return isset($this->max) ? $this->max : 0.0;
    }

    public function hasMax()
    {
        return isset($this->max);
    }

    public function clearMax()
    {
        unset($this->max);
    }

    /**
     * max is the maximum value over (start_time, end_time].
     *
     * Generated from protobuf field <code>optional double max = 12;</code>
     * @param float $var
     * @return $this
     */
    public function setMax($var)
    {
        GPBUtil::checkDouble($var);
        $this->max = $var;

        return $this;
    }

}

