<div>
    <form action="backstage_vote" method="post" name="vote_statistics"> 投票列表 -> 結果列表<br>
    投票標題：$vote_title<br>
      <br>
      <table align="left" border="1" cellpadding="1" cellspacing="1">
        <thead>
          <tr>
            <th scope="col"> 投　票　用　戶</th>
            <th scope="col"> 投　票　群　組</th>
            <th scope="col"> 投　票　內　容</th>
            <th scope="col"> 投　票　時　間</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td> $m_id</td>
            <td> $options_group</td>
            <td> $options_content</td>
            <td> $datetime</td>
          </tr>
        </tbody>
      </table>
      <br>
      <br>
      <br>
      </form>
</div>