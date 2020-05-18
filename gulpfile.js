/**
 * Gulpfile.
 *
 * Gulp with WordPress.
 *
 * Implements:
 * 1. Live reloads browser with BrowserSync.
 * 2. CSS: Sass to CSS conversion, error catching, Autoprefixing, Sourcemaps, CSS minification.
 * 3. JS: Concatenates & uglifies JS files.
 * 4. Images: Compress PNG, JPEG, GIF and SVG images.
 * 5. Translate: Generates .pot file for i18n and l10n.
 * 6. Watches files for changes in SCSS, CSS, JS, PHP & Images.
 * 7. Create a zip file containing all files needed for production only.
 *
 * @author Armand Philippot <https://www.armandphilippot.com/>
 */

/**
 * Load Gulp Configuration.
 *
 * TODO: Customize your project in the gulp.config.js file.
 */
const config = require('./gulp.config');

/**
 * Load Plugins.
 *
 * Load gulp plugins and passing them semantic names.
 */
const { src, dest, watch, series, parallel } = require('gulp'); // Gulp functions

// CSS plugins
const sass = require('gulp-sass'); // Compile scss to css.
const postcss = require('gulp-postcss'); // Post CSS.
const sorting = require('postcss-sorting'); // Sort CSS.
const autoprefixer = require('gulp-autoprefixer'); // Autoprefix CSS properties.
const cleancss = require('gulp-clean-css'); // Minify CSS files.
const rtlcss = require('gulp-rtlcss'); // Generate RTL stylesheet.

// JS plugins
const concat = require('gulp-concat'); // Concatenate JS files.
const uglify = require('gulp-uglify'); // Minify JS with UglifyJS3.
const babel = require('gulp-babel'); // Compile ESNext to browser compatible JS.

// Images plugins
const imagemin = require('gulp-imagemin'); // Images compression.
const svg2png = require('gulp-svg2png'); // Convert SVG to PNG.

// Utility plugins
const del = require('del');
const rename = require('gulp-rename'); // Rename files.
const lec = require('gulp-line-ending-corrector'); // Consistent Line Endings for non UNIX systems.
const filter = require('gulp-filter'); // Work on a subset of the original files by filtering them using globbing.
const sourcemaps = require('gulp-sourcemaps'); // Map code in a compressed file.
const sort = require('gulp-sort'); // Recommended to prevent unnecessary changes in pot-file.
const wppot = require('gulp-wp-pot'); // Generate the .pot file.
const notify = require('gulp-notify'); // Send message notification.
const plumber = require('gulp-plumber'); // Prevent pipe breaking caused by errors from gulp plugins.
const browserSync = require('browser-sync').create(); // Reload browser and inject CSS. Time-saving synchronized browser testing.
const zip = require('gulp-zip');

/**
 * Custom Error Handler.
 *
 * @param {*} err
 */
const onError = err => {
	notify({
		title: 'Gulp Task Error',
		message: 'Check the console.',
	}).write(err);
	console.log(err.toString());
	this.emit('end');
};

/**
 * Task: `clean`.
 *
 * Clean assets directory.
 */
function clean(done) {
	del(config.cleanConfig);
	done();
}

/**
 * Task: `bs`.
 *
 * Init Browser Sync.
 */
function bs(done) {
	browserSync.init(config.bsConfig);
	done();
}

/**
 * Task: `style`.
 *
 * Compile Sass, sort properties, autoprefix, minify CSS.
 *
 * This task does the following:
 * 1. Get the source files
 * 2. Compile SCSS to CSS
 * 3. Write sourcemaps for it
 * 4. Sort properties in alphabetical order
 * 5. Autoprefix it
 * 6. Move style.css to root directory
 * 7. Rename the CSS file with suffix .min.css
 * 8. Minify the CSS file
 * 9. Move style.min.css to root directory
 */
function style() {
	return src(config.src.styleSource)
		.pipe(plumber({ errorHandler: onError }))
		.pipe(sourcemaps.init())
		.pipe(sass(config.sassConfig))
		.on('error', onError)
		.pipe(sourcemaps.write({ includeContent: false }))
		.pipe(sourcemaps.init({ loadMaps: true }))
		.pipe(postcss([sorting(config.sortingConfig)]))
		.pipe(autoprefixer(config.BROWSERS_LIST))
		.pipe(sourcemaps.write('./'))
		.pipe(lec())
		.pipe(dest(config.dest.styleDest))
		.pipe(filter('**/*.css'))
		.pipe(browserSync.stream())
		.pipe(rename({ suffix: '.min' }))
		.pipe(cleancss())
		.pipe(lec())
		.pipe(dest(config.dest.styleDest))
		.pipe(filter('**/*.css'))
		.pipe(
			notify({
				title: 'Style Task Complete',
				message:
					'Styles have been compiled, concatenated, sorted, autoprefixed & minified.',
			})
		);
}

/**
 * Task: `styleRTL`.
 *
 * Compile Sass, sort properties, autoprefix, minify CSS.
 *
 * This task does the following:
 * 1. Get the source file
 * 2. Compile SCSS to CSS
 * 3. Write sourcemaps for it
 * 4. Sort properties in alphabetical order
 * 5. Autoprefix it
 * 6. Move style.css to root directory
 * 7. Rename the CSS file with suffix .min.css
 * 8. Minify the CSS file
 * 9. Move style.min.css to root directory
 */
function styleRTL() {
	return src(config.src.styleRTLSource)
		.pipe(plumber({ errorHandler: onError }))
		.pipe(sourcemaps.init())
		.pipe(sass(config.sassConfig))
		.on('error', onError)
		.pipe(sourcemaps.write({ includeContent: false }))
		.pipe(sourcemaps.init({ loadMaps: true }))
		.pipe(postcss([sorting(config.sortingConfig)]))
		.pipe(autoprefixer(config.BROWSERS_LIST))
		.pipe(lec())
		.pipe(rename({ suffix: '-rtl' }))
		.pipe(rtlcss())
		.pipe(sourcemaps.write('./'))
		.pipe(dest(config.dest.styleRTLDest))
		.pipe(filter('**/*.css'))
		.pipe(browserSync.stream())
		.pipe(rename({ suffix: '.min' }))
		.pipe(cleancss())
		.pipe(lec())
		.pipe(dest(config.dest.styleRTLDest))
		.pipe(filter('**/*.css'))
		.pipe(
			notify({
				title: 'StyleRTL Task Complete',
				message:
					'RTL styles have been compiled, concatenated, sorted, autoprefixed & minified.',
			})
		);
}

/**
 * Task: `stylePrint`.
 *
 * Compile Sass, sort properties, autoprefix, minify CSS.
 *
 * This task does the following:
 * 1. Get the source file
 * 2. Compile SCSS to CSS
 * 3. Write sourcemaps for it
 * 4. Sort properties in alphabetical order
 * 5. Autoprefix it
 * 6. Move style.css to root directory
 * 7. Rename the CSS file with suffix .min.css
 * 8. Minify the CSS file
 * 9. Move style.min.css to root directory
 */
function stylePrint() {
	return src(config.src.stylePrintSource)
		.pipe(plumber({ errorHandler: onError }))
		.pipe(sourcemaps.init())
		.pipe(sass(config.sassConfig))
		.on('error', onError)
		.pipe(sourcemaps.write({ includeContent: false }))
		.pipe(sourcemaps.init({ loadMaps: true }))
		.pipe(postcss([sorting(config.sortingConfig)]))
		.pipe(autoprefixer(config.BROWSERS_LIST))
		.pipe(sourcemaps.write('./'))
		.pipe(lec())
		.pipe(dest(config.dest.stylePrintDest))
		.pipe(filter('**/*.css'))
		.pipe(browserSync.stream())
		.pipe(rename({ suffix: '.min' }))
		.pipe(cleancss())
		.pipe(lec())
		.pipe(dest(config.dest.stylePrintDest))
		.pipe(filter('**/*.css'))
		.pipe(
			notify({
				title: 'StylePrint Task Complete',
				message:
					'Styles for print have been compiled, concatenated, sorted, autoprefixed & minified.',
			})
		);
}

/**
 * Task: `styleEditor`.
 *
 * Compile Sass, sort properties, autoprefix, minify CSS.
 *
 * This task does the following:
 * 1. Get the source file
 * 2. Compile SCSS to CSS
 * 3. Write sourcemaps for it
 * 4. Sort properties in alphabetical order
 * 5. Autoprefix it
 * 6. Move style.css to root directory
 * 7. Rename the CSS file with suffix .min.css
 * 8. Minify the CSS file
 * 9. Move style.min.css to root directory
 */
function styleEditor() {
	return src(config.src.styleEditorSource)
		.pipe(plumber({ errorHandler: onError }))
		.pipe(sourcemaps.init())
		.pipe(sass(config.sassConfig))
		.on('error', onError)
		.pipe(sourcemaps.write({ includeContent: false }))
		.pipe(sourcemaps.init({ loadMaps: true }))
		.pipe(postcss([sorting(config.sortingConfig)]))
		.pipe(autoprefixer(config.BROWSERS_LIST))
		.pipe(sourcemaps.write('./'))
		.pipe(lec())
		.pipe(dest(config.dest.styleEditorDest))
		.pipe(filter('**/*.css'))
		.pipe(browserSync.stream())
		.pipe(rename({ suffix: '.min' }))
		.pipe(cleancss())
		.pipe(lec())
		.pipe(dest(config.dest.styleEditorDest))
		.pipe(filter('**/*.css'))
		.pipe(
			notify({
				title: 'StyleEditor Task Complete',
				message:
					"Editor's styles have been compiled, concatenated, sorted, autoprefixed & minified.",
			})
		);
}

/**
 * Task: `styleVendors`.
 *
 * Compile Sass, sort properties, autoprefix, minify CSS.
 *
 * This task does the following:
 * 1. Get the source file
 * 2. Compile SCSS to CSS
 * 3. Write sourcemaps for it
 * 4. Sort properties in alphabetical order
 * 5. Autoprefix it
 * 6. Move style.css to root directory
 * 7. Rename the CSS file with suffix .min.css
 * 8. Minify the CSS file
 * 9. Move style.min.css to root directory
 */
function styleVendors() {
	return src(config.src.styleVendorsSource)
		.pipe(plumber({ errorHandler: onError }))
		.pipe(sourcemaps.init())
		.pipe(sass(config.sassConfig))
		.on('error', onError)
		.pipe(sourcemaps.write({ includeContent: false }))
		.pipe(sourcemaps.init({ loadMaps: true }))
		.pipe(postcss([sorting(config.sortingConfig)]))
		.pipe(autoprefixer(config.BROWSERS_LIST))
		.pipe(sourcemaps.write('./'))
		.pipe(lec())
		.pipe(dest(config.dest.styleVendorsDest))
		.pipe(filter('**/*.css'))
		.pipe(browserSync.stream())
		.pipe(rename({ suffix: '.min' }))
		.pipe(cleancss())
		.pipe(lec())
		.pipe(dest(config.dest.styleVendorsDest))
		.pipe(filter('**/*.css'))
		.pipe(
			notify({
				title: 'StyleVendors Task Complete',
				message:
					'Vendors styles have been compiled, concatenated, sorted, autoprefixed & minified.',
			})
		);
}

/**
 * Task: `js`.
 *
 * Concatenate and uglify JS scripts.
 *
 * This task does the following:
 * 1. Get the source files
 * 2. Concatenate all the files and generate scripts.js
 * 3. Move scripts.js to assets directory
 * 4. Rename the JS file with suffix .min.js
 * 5. Minify the JS file
 * 6. Move scripts.min.js to assets directory
 */
function js() {
	return src(config.src.jsSource)
		.pipe(plumber({ errorHandler: onError }))
		.pipe(concat(config.scriptConfig.jsOutputFilename + '.js'))
		.on('error', onError)
		.pipe(lec())
		.pipe(dest(config.dest.jsDest))
		.pipe(
			rename({
				basename: config.scriptConfig.jsOutputFilename,
				suffix: '.min',
			})
		)
		.pipe(uglify())
		.pipe(lec())
		.pipe(dest(config.dest.jsDest))
		.pipe(
			notify({
				title: 'JS Task Complete',
				message: 'Scripts have been concatenated & minified.',
			})
		);
}

/**
 * Task: `jsVendors`.
 *
 * Concatenate and uglify vendors JS scripts.
 *
 * This task does the following:
 * 1. Get the source files
 * 2. Concatenate all the files and generate scripts.js
 * 3. Move scripts.js to assets directory
 * 4. Rename the JS file with suffix .min.js
 * 5. Minify the JS file
 * 6. Move scripts.min.js to assets directory
 */
function jsVendors() {
	return src(config.src.jsVendorsSource)
		.pipe(plumber({ errorHandler: onError }))
		.pipe(concat(config.scriptConfig.jsVendorsOutputFilename + '.js'))
		.on('error', onError)
		.pipe(lec())
		.pipe(dest(config.dest.jsVendorsDest))
		.pipe(
			rename({
				basename: config.scriptConfig.jsVendorsOutputFilename,
				suffix: '.min',
			})
		)
		.pipe(uglify())
		.pipe(lec())
		.pipe(dest(config.dest.jsVendorsDest))
		.pipe(
			notify({
				title: 'JSVendors Task Complete',
				message: 'Vendors scripts have been concatenated & minified.',
			})
		);
}

/**
 * Task: `images`.
 *
 * Compress PNG, JPEG, GIF and SVG images.
 *
 * This task does the following:
 * 1. Get the source files
 * 2. Minify PNG, JPG, GIF and SVG images
 * 3. Save the optimized images in assets directory
 */
function images() {
	return src(config.src.imgSource)
		.pipe(plumber({ errorHandler: onError }))
		.pipe(
			imagemin([
				imagemin.gifsicle({ interlaced: true }),
				imagemin.mozjpeg({ quality: 75, progressive: true }),
				imagemin.optipng({ optimizationLevel: 5 }), // 0-7 low-high
				imagemin.svgo({
					plugins: [{ removeViewBox: true }, { cleanupIDs: false }],
				}),
			])
		)
		.on('error', onError)
		.pipe(dest(config.dest.imgDest))
		.pipe(
			notify({
				title: 'Images Task Complete',
				message: 'Images have been compressed.',
			})
		);
}

/**
 * Task: `svgToPng`.
 *
 * Convert SVG images to PNG.
 *
 * This task does the following:
 * 1. Get the SVG source files
 * 2. Convert SVG to PNG images
 * 3. Save the converted images in assets directory
 */
function svgToPng() {
	return src(config.src.svgSource)
		.pipe(plumber({ errorHandler: onError }))
		.pipe(svg2png())
		.on('error', onError)
		.pipe(dest(config.dest.svgDest))
		.pipe(
			notify({
				title: 'SVGToPNG Task Complete',
				message: 'SVG have been converted to PNG.',
			})
		);
}

/**
 * Task: `translate`.
 *
 * Generate a POT file.
 *
 * This task does the following:
 * 1. Get the source of all the PHP files
 * 2. Sort files in stream by path or any custom sort comparator
 * 3. Apply wpPot with the variable set at the top of this file
 * 4. Generate a .pot file and save it in languages directory
 */
function translate() {
	return src(config.src.potSource)
		.pipe(sort())
		.pipe(
			wppot({
				domain: config.translationConfig.textDomain,
				package: config.translationConfig.packageName,
				bugReport: config.translationConfig.bugReport,
				lastTranslator: config.translationConfig.lastTranslator,
				team: config.translationConfig.team,
			})
		)
		.pipe(
			dest(
				config.dest.potDest +
					'/' +
					config.translationConfig.translationFile
			)
		)
		.pipe(
			notify({
				title: 'Translate Task Complete',
				message: 'POT file generated.',
			})
		);
}

/**
 * Task: `moveFonts`.
 *
 * Move fonts folder from src to assets.
 */
function moveFonts() {
	return src(config.src.fontsSource)
		.pipe(dest(config.dest.fontsDest))
		.pipe(
			notify({
				title: 'moveFonts Task Complete',
				message: 'Fonts folder has been moved.',
			})
		);
}

/**
 * Task: `watchFiles`.
 *
 * Watch for file changes and runs specific tasks.
 *
 * This task does the following:
 * 1. Watch for changes in SCSS files and run style task
 * 2. Watch for changes in JS files and run js task
 * 3. Watch for changes in image files and run image task
 * 4. Watch for changes in SVG files and run svgToPng task
 * 5. Watch for changes in PHP files and run translate task
 */
function watchFiles(done) {
	watch(config.watch.styleFiles).on(
		'change',
		series(style, styleRTL, stylePrint, styleEditor, browserSync.reload)
	);
	watch(config.watch.styleVendorsFiles).on(
		'change',
		series(styleVendors, browserSync.reload)
	);
	watch(config.watch.jsFiles).on('change', series(js, browserSync.reload));
	watch(config.watch.jsVendorsFiles).on(
		'change',
		series(jsVendors, browserSync.reload)
	);
	watch(config.watch.imgFiles).on(
		'change',
		series(images, browserSync.reload)
	);
	watch(config.watch.svgFiles).on(
		'change',
		series(svgToPng, browserSync.reload)
	);
	watch(config.watch.potFiles).on(
		'change',
		series(translate, browserSync.reload)
	);
	watch(config.watch.fontsFiles).on(
		'change',
		series(moveFonts, browserSync.reload)
	);
	done();
}

/**
 * Task: `zipFolder`.
 *
 * Create a zip directory containing only files needed in production.
 */
function zipFolder() {
	return src(config.zipConfig.zipSource)
		.pipe(zip(config.zipConfig.zipFilename))
		.pipe(dest(config.zipConfig.zipDest))
		.pipe(
			notify({
				title: 'zipFolder Task Complete',
				message: 'ZIP file generated.',
			})
		);
}

exports.build = series(
	clean,
	parallel(
		style,
		styleRTL,
		stylePrint,
		styleEditor,
		js,
		images,
		svgToPng,
		translate,
		moveFonts
	),
	zipFolder
);

exports.default = parallel(bs, watchFiles);

exports.zipfolder = series(zipFolder);
