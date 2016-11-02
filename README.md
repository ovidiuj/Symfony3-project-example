Symfony project example
=======================

##Requirements

In a context of hypothetical job board project, the implementation is following user stories:

**User Story 1**
* As a HR manager I would like to go to job submission page, fill out a form and publish a job offer.
* COS:
    * new job form should contain title, description and email field.
    * when I hit submit button, if this is my first job posting i should receive email saying that my submission is in moderation, otherwise it should be public/published.

**User Story 2**
* As a job board moderator i would like to receive email every time someone posts a job for a first time.
* COS:
    * every time someone posts a job for a first time (based on email address) i should receive email about it
    * email notification should contain title and description of submission, as well as links to approve (publish) or mark it as a spam.

##Installation & Usage

* run ``` composer install ```
* go to ``` http://<YOUR_LOCAL_HOST>/job/ ``` to get the list  of all jobs