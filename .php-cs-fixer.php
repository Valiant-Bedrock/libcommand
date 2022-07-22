<?php

$finder = PhpCsFixer\Finder::create()->in(__DIR__ . "/src");
$rules = [
	"align_multiline_comment" => ["comment_type" => "phpdocs_only"],
	"array_indentation" => true,
	"array_syntax" => ["syntax" => "short"],
	"binary_operator_spaces" => ["default" => "single_space"],
	"blank_line_after_namespace" => true,
	"blank_line_after_opening_tag" => true,
	"blank_line_before_statement" => [
		"statements" => ["declare"]
	],
	"cast_spaces" => ["space" => "single"],
	"concat_space" => ["spacing" => "one"],
	"declare_strict_types" => true,
	"fully_qualified_strict_types" => true,
	"global_namespace_import" => [
		"import_constants" => true,
		"import_functions" => true,
		"import_classes" => null,
	],
	"indentation_type" => true,
	"logical_operators" => true,
	"native_function_invocation" => [
		"scope" => "namespaced",
		"include" => ["@all"],
	],
	"no_closing_tag" => true,
	"no_empty_phpdoc" => true,
	"no_extra_blank_lines" => true,
	"no_superfluous_phpdoc_tags" => ["allow_mixed" => true],
	"no_trailing_whitespace" => true,
	"no_trailing_whitespace_in_comment" => true,
	"no_whitespace_in_blank_line" => true,
	"no_unused_imports" => true,
	"ordered_imports" => [
		"imports_order" => [
			"class",
			"function",
			"const",
		],
		"sort_algorithm" => "alpha"
	],
	"phpdoc_line_span" => [
		"property" => "single",
		"method" => null,
		"const" => null
	],
	"phpdoc_trim" => true,
	"phpdoc_trim_consecutive_blank_line_separation" => true,
	"single_blank_line_at_eof" => false,
	"single_import_per_statement" => false,
	"single_space_after_construct" => true,
	"strict_param" => true,
	"unary_operator_spaces" => true,
];

return (new PhpCsFixer\Config)
	->setRiskyAllowed(true)
	->setRules($rules)
	->setFinder($finder)
	->setIndent("\t")
	->setLineEnding("\n");
