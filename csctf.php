<? require('headerdata.php'); ?>
<? $page_title = "CSCTF Stats - VOUPR"; ?>
<? include('header.php'); ?>

<?
    require "../secrets.inc";
    $db = mysqli_connect($sqlserver, $csctfsqluser, $csctfsqlpass, "csctf");

    // Team stats — aggregate from player_stat
    $team_result = mysqli_query($db,
        'SELECT team,
                SUM(captures)    AS captures,
                SUM(total_score) AS score,
                SUM(pks)         AS pks
           FROM player_stat
          GROUP BY team
          ORDER BY score DESC'
    );

    // Player rankings — sorted by score
    $player_result = mysqli_query($db,
        'SELECT name, team, total_score, captures, assists, pks
           FROM player_stat
          ORDER BY total_score DESC'
    );

    mysqli_close($db);
?>

<h3>CSCTF Stats</h3>

<h4>Team Stats</h4>
<table class="pluginlist" style="margin: 0 auto;">
    <tr class="heading">
        <td>Team</td>
        <td class="number">Captures</td>
        <td class="number">Score</td>
        <td class="number">PKs</td>
    </tr>
    <? while ($row = mysqli_fetch_assoc($team_result)) { ?>
    <tr>
        <td><?=htmlspecialchars($row['team'])?></td>
        <td class="number"><?=$row['captures']?></td>
        <td class="number"><?=$row['score']?></td>
        <td class="number"><?=$row['pks']?></td>
    </tr>
    <? } ?>
</table>

<br>

<h4>Player Rankings</h4>
<table class="pluginlist" style="margin: 0 auto;">
    <tr class="heading">
        <td class="number">Rank</td>
        <td>Player</td>
        <td>Team</td>
        <td class="number">Score</td>
        <td class="number">Captures</td>
        <td class="number">Assists</td>
        <td class="number">PKs</td>
    </tr>
    <? $rank = 1; while ($row = mysqli_fetch_assoc($player_result)) { ?>
    <tr>
        <td class="number"><?=$rank++?></td>
        <td><?=htmlspecialchars($row['name'])?></td>
        <td><?=htmlspecialchars($row['team'])?></td>
        <td class="number"><?=$row['total_score']?></td>
        <td class="number"><?=$row['captures']?></td>
        <td class="number"><?=$row['assists']?></td>
        <td class="number"><?=$row['pks']?></td>
    </tr>
    <? } ?>
</table>

<? include('footer.php'); ?>
