<?php
/**
 * ------------------------------------------------------------------
 * Shared program curriculum data.
 * ------------------------------------------------------------------
 * Single source of truth for the 14-week module ladder. Used by:
 *   • page-program.php  — renders the "Course content" accordion.
 *   • inc/visioner-nav.php — builds the nav search index so a query like
 *     "Angular 18" or "SQL Server" jumps straight to that module.
 *
 * Keep the order stable: the accordion anchors are `tc-module-{index}`.
 *
 * @package Techco Child
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! function_exists( 'tc_program_modules' ) ) {
	function tc_program_modules() {
		return array(
			array( 'phase' => 'Core',  'weeks' => 'Weeks 1–2',   'topic' => 'Frontend — Angular 18',        'milestone' => 'Responsive UI', 'lessons' => 12, 'mins' => 600, 'desc' => 'TypeScript, RxJS, components, routing and responsive, mobile-first UI.' ),
			array( 'phase' => 'Core',  'weeks' => 'Weeks 3–4',   'topic' => 'Backend — .NET 8 Web API',      'milestone' => 'REST API',      'lessons' => 11, 'mins' => 560, 'desc' => 'C#, Entity Framework Core and building structured RESTful services.' ),
			array( 'phase' => 'Core',  'weeks' => 'Weeks 5–6',   'topic' => 'SQL Server',                    'milestone' => 'Data layer',    'lessons' => 9,  'mins' => 470, 'desc' => 'Schema design, queries, stored procedures and data integration.' ),
			array( 'phase' => 'Core',  'weeks' => 'Weeks 7–8',   'topic' => 'Auth, Security & Mini-ERP',     'milestone' => 'Working app',   'lessons' => 10, 'mins' => 520, 'desc' => 'Authentication, security and a full-stack Mini-ERP (Angular + .NET + SQL).' ),
			array( 'phase' => 'Core',  'weeks' => 'Weeks 9–10',  'topic' => 'Capstone + Git/DevOps',         'milestone' => 'Capstone',      'lessons' => 8,  'mins' => 480, 'desc' => 'Build & ship a capstone with Git and DevOps fundamentals. Core Program ends here (10 weeks).' ),
			array( 'phase' => 'Cloud', 'weeks' => 'Weeks 11–12', 'topic' => 'Cloud — AWS & Azure',           'milestone' => 'Live on cloud', 'lessons' => 8,  'mins' => 430, 'desc' => 'Cloud fundamentals, CI/CD and deploying your capstone live (12 weeks).' ),
			array( 'phase' => 'AI',    'weeks' => 'Week 13',     'topic' => 'GenAI',                         'milestone' => 'AI feature',    'lessons' => 5,  'mins' => 300, 'desc' => 'LLM APIs, prompt engineering and building real AI features (13 weeks).' ),
			array( 'phase' => 'AI',    'weeks' => 'Week 14',     'topic' => 'Agentic AI',                    'milestone' => 'AI agent',      'lessons' => 5,  'mins' => 300, 'desc' => 'Agents, tools and autonomous automation workflows. Complete Bundle ends here (14 weeks).' ),
		);
	}
}

/**
 * Lightweight search index for the nav: one entry per module with a
 * lowercased haystack and the accordion anchor it maps to.
 */
if ( ! function_exists( 'tc_program_search_index' ) ) {
	function tc_program_search_index() {
		$out = array();
		foreach ( tc_program_modules() as $i => $m ) {
			$out[] = array(
				'id'    => 'tc-module-' . $i,
				'topic' => $m['topic'],
				'text'  => strtolower( trim( $m['topic'] . ' ' . $m['desc'] . ' ' . $m['phase'] . ' ' . $m['weeks'] . ' ' . $m['milestone'] ) ),
			);
		}
		return $out;
	}
}
