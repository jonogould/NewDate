## NEWDATE

The NewDate class allows you to extend the reach of the php `date()` function and also comes with a few other useful functions.

There is a limitation in php where the `date()` function does work outside of the date regions of 1901 - 2038. See changelog at (http://us.php.net/manual/en/function.date.php). This is where this class comes in handy. This class was used in an actuarial reporting program and performed very well compared to Excel's date functions.

It is fairly accurate, the only known issue being that it does not count leap years after 2038 (yet). But this is fairly insignificant.


### Usage

Basic usage:

- Include the class at the top of your php script. `<?PHP include(class.newDate.php); ?>`
- Create a new date with the format YYY-MM-DD `$birthday = new NewDate('1987-11-05')`
- Call a function `$birthday->addMonth();`
- See the results, which should say "1987-12-05" or "5 December 1987" depending on which function you use `echo $birthday;` or `echo $birthday->toLongFormat();`

### Feedback

Let me know if you find a bug or wish to see another feature added.

Have fun and goodluck using it!