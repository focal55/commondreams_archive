<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="2.0" 
                xmlns:html="http://www.w3.org/TR/REC-html40"
                xmlns:sitemap="http://www.sitemaps.org/schemas/sitemap/0.9"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" version="1.0" encoding="UTF-8" indent="yes"/>
	<xsl:template match="/">
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<title>XML Sitemap</title>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<style type="text/css">
					body {	font-family: Arial, sans-serif;	font-size: 13px; color: #545353;		}
					table {	border: none;	border-collapse: collapse;	}		
					#content {	margin: 0 auto;	width: 950px;	}
					a { color: #000; text-decoration: none;	}
					a:hover {	text-decoration: underline;	}
					td { font-size:11px;	}
					th { text-align:left;	padding-right:30px;	font-size:11px;	}
					thead th { border-bottom: 1px solid #000; cursor: pointer; font-size: 12px; }
					#intro { background-color:#CFEBF7;	border:1px #2580B2 solid;	padding:5px 13px 5px 13px;	margin-bottom:10px;	}
 					#intro p { line-height:	16.8667px;	}
				</style>
			</head>
			<body>
				<div id="content">						
					<div id="intro">
					<h1>XML Sitemap GENERATOR</h1>
					<p>
					This XML Sitemap will inform search engines, such as <a href="http://www.google.com" target="_blank">Google</a>, about the URLs on this website that are available for crawling. 
					You can find more information about XML sitemaps on <a href="http://sitemaps.org" target="_blank">sitemaps.org</a>.					
					</p>
					<p>This XML Sitemap contains <strong><xsl:value-of select="count(sitemap:urlset/sitemap:url)"/> </strong> URLs.</p>
					</div>
					<xsl:if test="count(sitemap:sitemapindex/sitemap:sitemap) &lt; 1">									
						<table cellpadding="3">
							<thead>
								<tr>
									<th width="60%">URL</th>
									<th title="Priority" width="10%">Priority</th>
									<th title="Change Frequency" width="15%">Change Frequency</th>
									<th title="Last Change" width="15%">Last Change</th>
								</tr>
							</thead>
							<tbody>
								<xsl:variable name="lower" select="'abcdefghijklmnopqrstuvwxyz'"/>
								<xsl:variable name="upper" select="'ABCDEFGHIJKLMNOPQRSTUVWXYZ'"/>
								<xsl:for-each select="sitemap:urlset/sitemap:url">
									<tr>
									  <xsl:if test="position() mod 2 = 1">
										<xsl:attribute name="bgcolor">#CCFFCC</xsl:attribute>
									  </xsl:if>
										<td>
											<xsl:variable name="itemURL">
												<xsl:value-of select="sitemap:loc"/>
											</xsl:variable>
											<a href="{$itemURL}">
												<xsl:value-of select="sitemap:loc"/>
											</a>
										</td>
										<td>
											<xsl:value-of select="concat(sitemap:priority*100,'%')"/>
										</td>
										<td>
											<xsl:value-of select="concat(translate(substring(sitemap:changefreq, 1, 1),concat($lower, $upper),concat($upper, $lower)),substring(sitemap:changefreq, 2))"/>
										</td>
										<td>
											<xsl:value-of select="concat(substring(sitemap:lastmod,0,11),concat(' ', substring(sitemap:lastmod,12,5)))"/>
										</td>
									</tr>
								</xsl:for-each>
							</tbody>
						</table>
					</xsl:if>
				</div>
			</body>
		</html>
	</xsl:template>
</xsl:stylesheet>