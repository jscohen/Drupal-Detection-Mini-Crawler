Drupal-Detection-Mini-Crawler
=============================

A PHP based mini-crawler that detects Drupal

In this mini crawler, just enter the URL of the site and it will be crawled for links.

Afterwards, all of the links will be checked using the same Drupal Detector as the Drupal detection script.

The ouput will be stored in a results.csv file.

This crawler is a simple tool that detects all of the link and puts them in an array for a give web page.  Afterwards, it checks them to see if they are in Drupal.
A table will be outputted to the screen for visual reference.  The main output source will be a CSV spreadsheet that will be created in the same directory as the script.

What I'm working on:

Deeper crawling (i.e. crawling a whole site rather than just one page)
Improving the Drupal detection script