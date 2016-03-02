# Memoizer

Simple PHP Memoizer class

[![Latest Stable Version](https://poser.pugx.org/ganglio/Memoizer/v/stable)](https://packagist.org/packages/ganglio/Memoizer)
[![Build Status](https://travis-ci.org/ganglio/Memoizer.svg?branch=master)](https://travis-ci.org/ganglio/Memoizer)
[![codecov.io](http://codecov.io/github/ganglio/Memoizer/coverage.svg?branch=master)](http://codecov.io/github/ganglio/Memoizer?branch=master)
[![Code Climate](https://codeclimate.com/github/ganglio/Memoizer/badges/gpa.svg)](https://codeclimate.com/github/ganglio/Memoizer)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/ganglio/Memoizer/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/ganglio/Memoizer/?branch=master)
[![License](https://poser.pugx.org/ganglio/Memoizer/license)](https://packagist.org/packages/ganglio/Memoizer)

The class allow to encapsulate any callable so that, during the first call (with a given set of arguments), the callable is executed and the return values are stored. At every successive call (with the same set of arguments) the stored value is used instead of invoking the callable again.

## Examples

This is a dumb example with a time variant call just to demonstate the way the memoized function works. If your callable has that kind of behaviour memoizing it is probably not a good idea :D

```PHP
$myFunc = function ($a) {
	return $a * mt_rand();
}

$myMemoizedFunc = new Memoizer($myFunc);

echo "Returns: " . $myMemoizedFunc(3) . "\n";
echo "Returns the same value: " . $myMemoizedFunc(3) . "\n";
```

A time consuming callable can be made more efficient storing the return value for later invokation.

```PHP
$mySlowFunc = function ($a) {
	sleep(5);
	return $a * mt_rand();
}

$myMemoizedSlowFunc = new Memoizer($mySlowFunc);

$st = time();
echo "Returns: " . $myMemoizedSlowFunc(3) . " in: " . (time() - $st);

$st = time();
echo "Returns the same value: " . $myMemoizedSlowFunc(3) . " in basically 0 time: " . (time() - $st);
```