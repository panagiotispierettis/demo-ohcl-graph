<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Stocks Prices</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('css/custom/main-style.css') }}">

    </head>
    <body>

      <div class="container main-container">

        <div id="page-title">
          <h1>Stock Prices</h1>
        </div>

        <div id="stock-symbol-search-form-container">
          <form id="stock-symbol-search-form">

            <div class="row">

              <div class="col-sm-2">
                <div class="form-group">
                  <label for="stockSymbol">Stock Symbol</label>
                  <input type="text" name="stockSymbol" class="form-control" value="" required>
                </div>
              </div>

              <div class="col-sm-2">
                <div class="form-group">
                  <label for="dateFrom">From</label>
                  <input type="date" name="dateFrom" class="form-control" value="">
                </div>
              </div>

              <div class="col-sm-2">
                <div class="form-group">
                  <label for="dateTo">To</label>
                  <input type="date" name="dateTo" class="form-control" value="">
                </div>
              </div>

            </div>

            <button type="submit" class="btn btn-default">Search</button>

          </form>
        </div>

        <div id="stock-info">
          <h2 id="stock-info-symbol"></h2>
          <h3 id="stock-info-name"></h3>
        </div>

        <div id="stock-chart-container">
          <div id="stock-chart">

          </div>
        </div>

        <div id="message-container">
          <div class="message-body">Please wait ...</div>
        </div>

      </div>
      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
      <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
      <script src="{{ asset('js/custom/main.js') }}"></script>
    </body>
</html>
