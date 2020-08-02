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
define( 'AUTH_KEY',         'IT-:kbt1R+rNMEsE`2TgbIg]jX7kXb[/:U,bH/v?Yr/MC1`,E9>/n&MV3gC z8F@' );
define( 'SECURE_AUTH_KEY',  'cz${CpD=SJo;T) #IT3x*XO*$w[lA*)hM2<Slfeu[MrtMI,*,u{-56C/fPRsqo;C' );
define( 'LOGGED_IN_KEY',    '#Tp+8f=c1A:U!3{Bau9-@peGOF2Tc1.}D+g5M@6;*7gl%bE_;F ]iXBcb7_UrFwM' );
define( 'NONCE_KEY',        'x_dWbn|4d|GIK&9Pvmm+fy}F5h6=r+FY%bm>{vK.i2MS6 &W.k@{wln~+,JPf$` ' );
define( 'AUTH_SALT',        ']rqCJK;mROyU{2ggaPs#z>&`d3~Dk[Y%zJ0AQ&r!BEx;6uARSVP:Qa4=x(:]C#q>' );
define( 'SECURE_AUTH_SALT', 'fkj[MX_4,UpJ_oJljNovET}c%CKIP_vKp:qX_o*]qAsGkMg*n0,91|Z3v-Sb-?`%' );
define( 'LOGGED_IN_SALT',   'r.)<]`[~{w!efYw|N.~9>?lj[hU_&=PJk6-1}IVL~]??<hrmdymd(g9[)#8}mbbL' );
define( 'NONCE_SALT',       'nzFQS(VpWS%j$}Of+1l^!uF_!p{bz*1rai+/4A=NW3bCBL2EEMO78bpd35!IS)YY' );

/**#@-*/

/**
 * WordPress データベーステーブルの接頭辞
 *
 * それぞれにユニーク (一意) な接頭辞を与えることで一つのデータベースに複数の WordPress を
 * インストールすることができます。半角英数字と下線のみを使用してください。
 */
$table_prefix = 'press';

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

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
