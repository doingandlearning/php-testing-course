## Blog demo application

This repo contains a demo application that we will use for this course in testing.

## Setting yourself up for success

- Clone and set up the project. Make sure it is working before the course starts.
- Have a look at the topic list at the end of this page - have a think about things you're excited about and things you think are missing. This list is what I have planned for the 3 days together but we can dive deeper or be more shallow with some of the concepts depending on the interest in the room.
- As well as the code-along and discussion time, there will be time for you to practice these skills live. To make this more relevant, it would be worth you having a codebase or project you want to apply these principles to. Create a new branch and use it for practice.


## Install
- Clone the repo
```bash
git clone https://github.com/doingandlearning/php-testing-course.git && cd php-testing-course
```
- Login to MySQL monitor and create the database
```mysql
mysql -u root -p
create database testing_course_blog;
exit;
```
- Install dependencies, migrate and start the demo
```bash
composer install
cp .env.example .env
php artisan key:generate
npm install
php artisan migrate --seed 
php artisan serve 
```

The admin account details have an email of `test@test.com` and a password of `letmein`.

## Coure notes

We will be using PHPUnit to write and run our tests. During the course, we will be exploring the philosophy of testing approaches and the practical applications of each of them.

We'll largely be adding tests to this existing projects, exploring what is possible and the best practices. 

We'll also have opportunities to use these strategies on projects you already have. So, if you can, bring a project you've built before and see how some of the principles we are exploring apply to your real-life work.

Topics we'll explore:
- Comprehensive Feature Testing
- Database Integration in Tests
- Utilizing Model Factories
- Form Testing Techniques
- Crafting JSON Assertions
- Implementing Authenticated Test Scenarios
- Managing Relationships with Factories
- Employing Test Fakes
- Effective Mocking Strategies
- Harnessing the Power of Mockery
- Time-sensitive Test Cases
- Middleware Testing Approaches
- Validation Testing Best Practices
- File Upload Test Scenarios
- Policy Testing Fundamentals
- Console Application Testing
- Blade Component Test Methods
- Testing Livewire Components
- Browser Test Implementation
- Laravel Dusk Usage
- Custom Factory Creation
- Job Testing Techniques
- Leveraging the HTTP Facade
- Data Providers for Test Cases
- Parallel Testing Optimization
- Domain Code Testing Principles
- Snapshot Testing Insights
- Test-Driven Development (TDD) Practices
- Integrating Tests with Continuous Integration (CI)
- Regression Testing Methods
- Exception Testing Approaches
- Test-Driven Refactoring Strategies
