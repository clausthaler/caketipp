<?php


App::uses('CakeEmail', 'Network/Email');

/**
 *  this shell can be used to send out reminder emails
 */
class TippreminderShell extends AppShell {
  public $uses = array('User', 'Tipp', 'Match');

  public function main() {
    $days = 2;
    Configure::write('Config.language', 'deu');
    // get all tippers that want to be reminded
    $users = $this->User->find('all', array(
      'conditions' => array('recieve_reminders' => 1, 'active' => 1),
      'fields' => array('username', 'email', 'id')));
    $users = Hash::combine($users, '{n}.User.id','{n}.User');

    //check for every user if tipps are outstanding
    $matches = $this->Match->query("SELECT u.id, u.username, a.kickoff, a.name, a.id FROM matches a, users u  "
      ." WHERE u.recieve_reminders and u.active = 1" 
      ." AND a.kickoff between UNIX_TIMESTAMP() AND UNIX_TIMESTAMP() + 2 * 86400  "
      ." AND NOT EXISTS (SELECT 'X' FROM tipps b WHERE a.id = b.match_id and b.user_id = u.id )" 
      ."order by u.id, a.name;");

    $missings = Hash::combine($matches, '{n}.a.id','{n}.a', '{n}.u.id');

    foreach ($missings as $userkey => $missedmatches) {
      if (array_key_exists($userkey, $users)) {
        $Email = new CakeEmail('dd24');
        $Email->template('tippreminder');
        $Email->emailFormat('text');
        $Email->from(array('noreply@tipp4fun.eu' => 'Dirks WM2018'));
        $Email->to($users[$userkey]['email']);
        $Email->subject('Tipperinnerung');
//        $this->out(print_r($Email,true));
        $Email->viewVars(array(
          'matches' => $missedmatches,
          'username' => $users[$userkey]['username']));
        $Email->send('My message');        
        
      }
    }


}
}
?>