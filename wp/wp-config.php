<?php
/**
 * WordPress の基本設定
 *
 * このファイルは、インストール時に wp-config.php 作成ウィザードが利用します。
 * ウィザードを介さずにこのファイルを "wp-config.php" という名前でコピーして
 * 直接編集して値を入力してもかまいません。
 *
 * このファイルは、以下の設定を含みます。
 *
 * * MySQL 設定
 * * 秘密鍵
 * * データベーステーブル接頭辞
 * * ABSPATH
 *
 * @link https://ja.wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

/*

// WP_DEBUG モードを有効化
define( 'WP_DEBUG', true );

// /wp-content/debug.log ファイルへのデバッグログの出力を有効化
define( 'WP_DEBUG_LOG', true );

// エラーと警告の画面への表示を無効化
define( 'WP_DEBUG_DISPLAY', false );
@ini_set( 'display_errors', 0 );

// 「開発版」のコア JavaScript と CSS ファイルを使用 (これらのコアファイルを変更する場合のみ必要)
define( 'SCRIPT_DEBUG', true );
*/


// 注意:
// Windows の "メモ帳" でこのファイルを編集しないでください !
// 問題なく使えるテキストエディタ
// (http://wpdocs.osdn.jp/%E7%94%A8%E8%AA%9E%E9%9B%86#.E3.83.86.E3.82.AD.E3.82.B9.E3.83.88.E3.82.A8.E3.83.87.E3.82.A3.E3.82.BF 参照)
// を使用し、必ず UTF-8 の BOM なし (UTF-8N) で保存してください。

// ** MySQL 設定 - この情報はホスティング先から入手してください。 ** //
/** WordPress のためのデータベース名 */
define( 'DB_NAME', 'tiltowait_tmpl' );

/** MySQL データベースのユーザー名 */
define( 'DB_USER', 'tiltowait_tmpl' );

/** MySQL データベースのパスワード */
define( 'DB_PASSWORD', 'kk1941' );

/** MySQL のホスト名 */
define( 'DB_HOST', 'localhost' );

/** データベースのテーブルを作成する際のデータベースの文字セット */
define( 'DB_CHARSET', 'utf8mb4' );

/** データベースの照合順序 (ほとんどの場合変更する必要はありません) */
define( 'DB_COLLATE', '' );

/**#@+
 * 認証用ユニークキー
 *
 * それぞれを異なるユニーク (一意) な文字列に変更してください。
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org の秘密鍵サービス} で自動生成することもできます。
 * 後でいつでも変更して、既存のすべての cookie を無効にできます。これにより、すべてのユーザーを強制的に再ログインさせることになります。
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'rnj,cmk_m<dlei8/C:YuIEv!>p_x|hptLE4Koj`P>:]vB451lAt&g$98>9}UaDa?' );
define( 'SECURE_AUTH_KEY',  'hGK+t=NaK21nbA.u]kR-gfuH.Io;wE6f[N1M% H|x0l-T|eQH[-|5QEQw=Kk0hXx' );
define( 'LOGGED_IN_KEY',    ']b:r4Oz3z8&]E=N~lK.%)sRkn@hjcWUfN4Ok}BRe4k7l`;J.-cwG4*q;eeQZhmp0' );
define( 'NONCE_KEY',        '+I^%;,E8 /4VP&y$P1yy#&I:#C,?&9JIn0|**0/qP>7ivc3x^i;Ol161RKsN4C6s' );
define( 'AUTH_SALT',        'p iu%%@q)VHTfTBw-PFhm/,+W:QTz~%+A.c ;j^QDDG{@A7{uP+MhN?gDTJTtxYj' );
define( 'SECURE_AUTH_SALT', '2;1+0bg>lRBe`~@|Y[li&A?6-wLRF%(j<ivw($hRzN(6!w1j#ZE8H$o_dn_T]n)O' );
define( 'LOGGED_IN_SALT',   '$7,s}e$(UNg]f`%r_jX6#H6r}r>ki8ez *(RK55?SD}dbsk>b-Kd>.ol7foaiFNr' );
define( 'NONCE_SALT',       '-)jL9Tgkjb8a}mN2tM_3*w@8$% >@+CS99G6%6J@;d:no}.*E$;%`$6:a6Gmd^cj' );

/**#@-*/

/**
 * WordPress データベーステーブルの接頭辞
 *
 * それぞれにユニーク (一意) な接頭辞を与えることで一つのデータベースに複数の WordPress を
 * インストールすることができます。半角英数字と下線のみを使用してください。
 */
$table_prefix = 'wp01_';

/**
 * 開発者へ: WordPress デバッグモード
 *
 * この値を true にすると、開発中に注意 (notice) を表示します。
 * テーマおよびプラグインの開発者には、その開発環境においてこの WP_DEBUG を使用することを強く推奨します。
 *
 * その他のデバッグに利用できる定数についてはドキュメンテーションをご覧ください。
 *
 * @link https://ja.wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* 編集が必要なのはここまでです ! WordPress でのパブリッシングをお楽しみください。 */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}


ini_set('allow_url_fopen', 'off');

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
