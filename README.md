# NFLTeams
A wordpress plugin created to prove ability to code a solution to a problem.

## Dependicies
* [jQuery](https://jquery.com/)
* [Flexbox SCSS Mixins](https://gist.github.com/superfine/b8d09752a67b4e2f224bb34cb5ca9f94)
* [Football SVG](https://commons.wikimedia.org/wiki/File:Football_(11390)_-_The_Noun_Project.svg)

## Capabilities
* Display all NFL Teams in an alphabetical list.
* Flip card effect on frontend to hide team information until they are selected.
* Ability to choose to organize by team, conference, or division.
* Easy to use shortcode for quick implementation.
* Data provided by third party API

## How to use
1. Import the ZIP file into your WordPress Blog and activate the plugin.
2. Navigate to the plugin's page titled "NFL Teams" and enter in the API key for the API provided within the email.
3. Add the shortcode `[nflteams]` where you want the information to appear.

### Sort Options
By adding the "sort" parameter to the shortcode you can choose to organize the teams by Team, Division, or Conference.

**Accepted Values:** "team", "division", "conference"

Example: `[nflteams sort="division"]`

## Project Decisions and Assumptions
I had to assume that we only needed to support modern browsers. This code is not intended to support IE9 and older.

I've decided to allow ACME Sports to have the most control over the display of the teams to make the plugin more adaptable. By using a shortcode and allowing them to organize by team, division, or conference, the plugin can work with the content of the page, instead of dictating how the page's content should look. The css is purposefully minimal to allow the design to be easily modified depending on the look of the website.

Where the API provided limited information, I utilized what I could to ensure that viewers could get the maximum information while allowing the design to retain a minimal look.

I decided to take this coding opportunity to highlight my ability with building for WordPress and highlight my skill in 4 major categories, CSS/SCSS, HTML, PHP, and JS/jQuery. A plugin was the obvious choice to succeed in this task.
