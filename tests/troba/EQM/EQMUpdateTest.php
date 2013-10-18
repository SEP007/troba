<?php

use troba\EQM\EQM;
use troba\EQM\EQMException;

class EQMUpdateTest extends PHPUnit_Framework_TestCase
{
    public function testUpdateDefault()
    {
        $c = EQM::queryByArray([
            'entity' => new AnotherCompany(),
            'query' => 'id = ?',
            'params' => CNT_COMPANY + 1
        ])->one();
        $c->remark = $c->remark . ' no from testUpdate(AnotherCompany)';
        EQM::update($c);
        $this->assertEquals($c->remark, EQM::queryByArray([
            'entity' => new AnotherCompany(),
            'query' => 'id = ?',
            'params' => $c->id
        ])->one()->remark);

        $c = EQM::queryByArray([
            'entity' => new Company(),
            'query' => 'id = ?',
            'params' => CNT_COMPANY + 2
        ])->one();
        $c->remark = $c->remark . ' no from testUpdate(Company)';
        EQM::update($c);
        $this->assertEquals($c->remark, EQM::queryByArray([
            'entity' => new Company(),
            'query' => 'id = ?',
            'params' => $c->id
        ])->one()->remark);

        $p = EQM::queryByArray([
            'entity' => new Project(),
            'query' => 'id = ?',
            'params' => $c->id . '_PROJECT'
        ])->one();
        $p->name = $p->name . ' from testUpdate(Project)';
        EQM::update($p);
        $this->assertEquals($p->name, EQM::queryByArray([
            'entity' => new Project(),
            'query' => 'id = ?',
            'params' => $p->id
        ])->one()->name);

        $pa = EQM::queryByArray([
            'entity' => new ProjectActivity(),
            'query' => 'id = ? AND projectId = ?',
            'params' => [999, $p->id]
        ])->one();
        $pa->name = $pa->name . ' from testUpdate(ProjectActivity)';
        EQM::update($pa);
        $this->assertEquals($pa->name, EQM::queryByArray([
            'entity' => new ProjectActivity(),
            'query' => 'id = ? AND projectId = ?',
            'params' => [$pa->id, $p->id]
        ])->one()->name);
    }

    public function testUpdateDefaultWithNameSpace()
    {
        $c = EQM::queryByArray([
            'entity' => new Bootstrap\AnotherCompany(),
            'query' => 'id = ?',
            'params' => CNT_COMPANY + 3
        ])->one();
        $c->remark = $c->remark . ' no from testUpdate(AnotherCompany)';
        EQM::update($c);
        $this->assertEquals($c->remark, EQM::queryByArray([
            'entity' => new Bootstrap\AnotherCompany(),
            'query' => 'id = ?',
            'params' => $c->id
        ])->one()->remark);

        $c = EQM::queryByArray([
            'entity' => new Bootstrap\Company(),
            'query' => 'id = ?',
            'params' => CNT_COMPANY + 4
        ])->one();
        $c->remark = $c->remark . ' no from testUpdate(Company)';
        EQM::update($c);
        $this->assertEquals($c->remark, EQM::queryByArray([
            'entity' => new Bootstrap\Company(),
            'query' => 'id = ?',
            'params' => $c->id
        ])->one()->remark);

        $p = EQM::queryByArray([
            'entity' => new Bootstrap\Project(),
            'query' => 'id = ?',
            'params' => $c->id . '_PROJECT'
        ])->one();

        $p->name = $p->name . ' from testUpdate(Project)';
        EQM::update($p);
        $this->assertEquals($p->name, EQM::queryByArray([
            'entity' => new Bootstrap\Project(),
            'query' => 'id = ?',
            'params' => $p->id
        ])->one()->name);

        $pa = EQM::queryByArray([
            'entity' => new Bootstrap\ProjectActivity(),
            'query' => 'id = ? AND projectId = ?',
            'params' => [999, $p->id]
        ])->one();
        $pa->name = $pa->name . ' from testUpdate(ProjectActivity)';
        EQM::update($pa);
        $this->assertEquals($pa->name, EQM::queryByArray([
            'entity' => new Bootstrap\ProjectActivity(),
            'query' => 'id = ? AND projectId = ?',
            'params' => [$pa->id, $p->id]
        ])->one()->name);
    }

    public function testUpdateClassic()
    {
        EQM::activateConnection('second_db');

        $c = EQM::queryByArray([
            'entity' => new Company(),
            'query' => 'id = ?',
            'params' => CNT_COMPANY + 1
        ])->one();
        $c->remark = $c->remark . ' no from testUpdate(Company)';
        EQM::update($c);
        $this->assertEquals($c->remark, EQM::queryByArray([
            'entity' => new Company(),
            'query' => 'id = ?',
            'params' => $c->id
        ])->one()->remark);

        $p = EQM::queryByArray([
            'entity' => new Project(),
            'query' => 'id = ?',
            'params' => $c->id . '_PROJECT'
        ])->one();
        $p->name = $p->name . ' from testUpdate(Project)';
        EQM::update($p);
        $this->assertEquals($p->name, EQM::queryByArray([
            'entity' => new Project(),
            'query' => 'id = ?',
            'params' => $p->id
        ])->one()->name);

        $pa = EQM::queryByArray([
            'entity' => new ProjectActivity(),
            'query' => 'id = ? AND projectId = ?',
            'params' => [999, $p->id]
        ])->one();
        $pa->name = $pa->name . ' from testUpdate(ProjectActivity)';
        EQM::update($pa);
        $this->assertEquals($pa->name, EQM::queryByArray([
            'entity' => new ProjectActivity(),
            'query' => 'id = ? AND projectId = ?',
            'params' => [$pa->id, $p->id]
        ])->one()->name);

        EQM::activateConnection('second_db');
    }

    public function testUpdateClassicWithNamespace()
    {
        EQM::activateConnection('second_db');

        $c = EQM::queryByArray([
            'entity' => new Bootstrap\Company(),
            'query' => 'id = ?',
            'params' => CNT_COMPANY + 1
        ])->one();
        $c->remark = $c->remark . ' no from testUpdate(Company)';
        EQM::update($c);
        $this->assertEquals($c->remark, EQM::queryByArray([
            'entity' => new Bootstrap\Company(),
            'query' => 'id = ?',
            'params' => $c->id
        ])->one()->remark);

        $p = EQM::queryByArray([
            'entity' => new Bootstrap\Project(),
            'query' => 'id = ?',
            'params' => $c->id . '_PROJECT'
        ])->one();
        $p->name = $p->name . ' from testUpdate(Project)';
        EQM::update($p);
        $this->assertEquals($p->name, EQM::queryByArray([
            'entity' => new Bootstrap\Project(),
            'query' => 'id = ?',
            'params' => $p->id
        ])->one()->name);

        $pa = EQM::queryByArray([
            'entity' => new Bootstrap\ProjectActivity(),
            'query' => 'id = ? AND projectId = ?',
            'params' => [999, $p->id]
        ])->one();
        $pa->name = $pa->name . ' from testUpdate(ProjectActivity)';
        EQM::update($pa);
        $this->assertEquals($pa->name, EQM::queryByArray([
            'entity' => new Bootstrap\ProjectActivity(),
            'query' => 'id = ? AND projectId = ?',
            'params' => [$pa->id, $p->id]
        ])->one()->name);

        EQM::activateConnection();
    }

    public function testUpdateError()
    {
        $c = new Company();
        try {
            EQM::update($c);
            $r = true;
        } catch (EQMException $e) {
            $r = false;
        }
        $this->assertFalse($r);

    }

}
