Feature:
    Shout API

    Scenario: It returns status 400 on missing limit parameter
        When I send a GET request to "/api/v1/shout/kevin-kruse"
        Then the response should be in JSON
        Then the response status code should be 400
        Then the JSON node message should be equal to "Parameter 'limit' is required"

    Scenario: It returns status 400 when limit parameter being too low
        When I send a GET request to "/api/v1/shout/kevin-kruse?limit=-1"
        Then the response should be in JSON
        Then the response status code should be 400
        Then the JSON node message should be equal to "Parameter 'limit' must be a value between 1 and 10"

    Scenario: It returns status 400 when limit parameter being too high
        When I send a GET request to "/api/v1/shout/kevin-kruse?limit=11"
        Then the response should be in JSON
        Then the response status code should be 400
        Then the JSON node message should be equal to "Parameter 'limit' must be a value between 1 and 10"

    Scenario: It returns status 200 with quotes
        When I send a GET request to "/api/v1/shout/kevin-kruse?limit=10"
        Then the response should be in JSON
        Then the response status code should be 200
        Then the JSON should be equal to:
        """
        ["LIFE ISN\u2019T ABOUT GETTING AND HAVING, IT\u2019S ABOUT GIVING AND BEING.!","WE MUST BALANCE CONSPICUOUS CONSUMPTION WITH CONSCIOUS CAPITALISM.!"]
        """

