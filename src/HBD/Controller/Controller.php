<?php

namespace HBD\Controller;


use Doctrine\DBAL\Connection;
use Symfony\Component\HttpFoundation\Request;

class Controller
{

    /** @var Connection */
    private $database;

    /** @var Request */
    private $request;

    /**
     * Controller constructor.
     * @param Connection $database
     */
    public function __construct(Connection $database, Request $request){
        $this->database = $database;
        $this->request = $request;
    }

    /**
     * @param string $table_name
     * @return array
     */
    public function findAll($table_name){
        return $this->database->createQueryBuilder()
            ->select('*')->from($table_name)
            ->execute()
            ->fetchAll();
    }


    /**
     * @param string $table_name
     * @param int $id
     * @return array
     */
    public function find($table_name, $id){
        return $this->database->createQueryBuilder()
            ->select('*')->from($table_name)
            ->where('id = :id')->setParameter('id', $id)
            ->execute()
            ->fetch();
    }


    /**
     * @param string $table_name
     * @return array
     */
    public function post($table_name){
        $data = $this->checkFields($table_name);

        $query = $this->database->createQueryBuilder()->insert($table_name);
        foreach ($data as $field => $value){
            $query->setValue($field, ':'.$field)
                ->setParameter($field, $value);
        }
        $query->execute();
        return $this->find($table_name, $this->database->lastInsertId());

    }

    /**
     * @param string $table_name
     * @param int $id
     * @return array
     */
    public function put($table_name, $id){
        $data = $this->checkFields($table_name);

        $query = $this->database->createQueryBuilder()->update($table_name);
        foreach ($data as $field => $value){
            $query->set($field, ':'.$field)->setParameter($field, $value);
        }
        $query->where('id = :id')->setParameter('id', $id)->execute();
        return $this->find($table_name, $id);

    }

    /**
     * @param string $table_name
     * @param int $id
     * @return \Doctrine\DBAL\Driver\Statement|int
     */
    public function delete($table_name, $id){
        return $this->database->createQueryBuilder()
            ->delete($table_name)
            ->where('id = :id')
            ->setParameter('id', $id)
            ->execute();
    }

    /**
     * @param string $table_name
     * @return array
     */
    protected function getFieldsAuthorizedToChange($table_name)
    {
        $data = $this->database->executeQuery("SHOW COLUMNS FROM ".$table_name)->fetchAll();
        $fields = [];
        foreach ($data as $key => $field){
            if( $field['Extra'] == 'auto_increment' ) continue;
            $fields[] = $field['Field'];
        }
        return $fields;
    }

    /**
     * @param string $table_name
     * @return array
     */
    protected function checkFields($table_name){
        $fields = $this->getFieldsAuthorizedToChange($table_name);
        $data = [];
        if( $this->request->getMethod() == Request::METHOD_POST )
            $data = $this->request->request->all();
        elseif( $this->request->getMethod() == Request::METHOD_PUT ){
            parse_str($this->request->server->get('QUERY_STRING'), $data);
        }
        foreach ($data as $field => $value){
            if( !in_array($field, $fields) ) unset($data[$field]);
        }
        return $data;
    }

}