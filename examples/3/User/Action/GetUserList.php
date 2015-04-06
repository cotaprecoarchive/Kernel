<?php

use CotaPreco\Action\ExecutableHttpActionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Andrey K. Vital <andreykvital@gmail.com>
 */
final class GetUserList implements ExecutableHttpActionInterface
{
    /**
     * @var PDO
     */
    private $dbh;

    /**
     * @param PDO $dbh
     */
    public function __construct(PDO $dbh)
    {
        $this->dbh = $dbh;
    }

    /**
     * {@inheritDoc}
     */
    public function execute(Request $request)
    {
        $statement = $this->dbh->query('SELECT * FROM users;');

        /* @var string[][] $userList */
        $userList  = $statement->fetchAll(PDO::FETCH_ASSOC);

        return JsonResponse::create([
            'users' => $userList
        ]);
    }
}
