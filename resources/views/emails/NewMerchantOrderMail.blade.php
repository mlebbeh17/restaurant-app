<!DOCTYPE>
<html>
<body>
  <table width="100%" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center">
        <table width="100%" cellpadding="0" cellspacing="0">
          <tr>
            <td >
              <a >{{ config('app.name') }}</a>
            </td>
          </tr>
          <tr>
            <td width="100%">
              <table align="left" width="570" cellpadding="0" cellspacing="0">
                <tr>
                  <td>
                    <h1>Ingredient order</h1>
                    <p>Dear {{ $receiver_name}},</p>
                    <p>Ths is new {{$ingredient_name}} order</p>
                    <p>Thanks,<br>{{ config('app.name') }}</p>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>