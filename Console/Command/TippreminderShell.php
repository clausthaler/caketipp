<?php

class TippreminderShell extends AppShell {
  public $uses = array('User', 'Tipp', 'Match');

  public function main() {
    $days = 7;
    // get all tippers that want to be reminded
    $users = $this->User->find('list', array(
      'conditions' => array('recieve_reminders' => 1, 'active' => 1),
      'fields' => array('username', 'email', 'id')));
    $this->out(print_r($users, true));
    // get all matches that are due on the next day
    $matches = $this->Match->find('list', array(
      'conditions' => array(
        'due <' => (time() + 7 * 86400), 
        'due >' => time() + 6 * 86400),
      'fields' => array('id')));
    $this->out(print_r($matches, true));

    //check for every user if tipps are outstanding
    foreach ($users as $key => $user) {
      $matches = $this->Match->query("SELECT * FROM matches a  WHERE a.due <= UNIX_TIMESTAMP() + " . $days * 86400 . 
      " AND a.kickoff >= UNIX_TIMESTAMP() + 6 * 86400 AND  NOT EXISTS (SELECT 'X' FROM tipps b " .
      " WHERE b.user_id = '" . $key . "' " .
      " AND a.id = b.match_id);");
      $matches = Hash::combine($matches, '{n}.a.id', '{n}.a');
      if (count($matches) > 0) {
        print_r($matches);
      }
    }
  }
}

?>