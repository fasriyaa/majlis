
    <tr>
      <td>Budget </td>
      <td></td>
      <td>
            <font color = "green">{{$base_currency}} {{number_format($task['budget']['budget'])}}</font>
      </td>
    </tr>
      <?php $committed = 0; ?>
      @foreach($task['contracts'] as $contracts)
          <tr>
              <td>Contract: {{$contracts['name']}} </td>
              <td><font color = "red">{{$base_currency}} {{number_format($contracts['base_curr_eqv'])}}</font></td>
              <td></td>
          </tr>
      <?php $committed = $committed + $contracts['base_curr_eqv']; ?>
      @endforeach

      @foreach($variations as $variation)
          <tr>
              <td>
                @foreach($variation->timeline as $timelines)
                  @if($timelines['type'] == 11)
                    Variation: {{$timelines['text']}}
                    <?php break; ?>
                  @endif
                @endforeach
              </td>
              <td>

                <font color = "red">{{$base_currency}} {{number_format($variation->variation_amount/$variation->contract['currency']['xrate'])}}</font>
              </td>
              <td></td>
          </tr>
      <?php $committed = $committed + $variation->variation_amount/$variation->contract['currency']['xrate']; ?>
      @endforeach


    <tr>
      <td>Total committed </td>
      <td></td>
      <td><font color = "red">({{$base_currency}} {{number_format($committed)}})</font></td>
    </tr>

    <tr>
      <td>Balance Availabe </td>
      <td></td>
      <td>
        <?php if($task['budget']['budget'] - $committed < 0){$col = "red";}else{$col="green";} ?>
        <font color = "{{$col}}">{{$base_currency}} {{number_format($task['budget']['budget'] - $committed)}}</font>
      </td>
    </tr>
